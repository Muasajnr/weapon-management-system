<?php

namespace App\Modules\APIs\SaranaKeamanan\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\SaranaKeamanan\Models\SaranaKeamananModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Exception;

class DefaultController extends ApiController
{

    private $SKModel;

    public function __construct()
    {
        parent::__construct();
        $this->SKModel = new SaranaKeamananModel();
    }

    // datatable
    public function datatables($id)
    {
        $posts = $this->request->getPost();
        $data = $this->SKModel->customDatatable($posts, (int)$id);

        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['id']."\">{$num}.";
            $row[]      = $item['nomor_sarana'];
            $row[]      = $item['nomor_bpsa'];
            $row[]      = $item['nama'];
            $row[]      = $item['merk'];
            $row[]      = $item['kondisi'];
            $row[]      = $item['keterangan'];
            $row[]      = $this->buildActionButtons($item['id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->SKModel->customCountTotalDatatable($posts, (int)$id);
        $output['recordsFiltered']  = $this->SKModel->customCountTotalFilteredDatatable((int) $id);
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    // create
    public function create($id)
    {
        try {            
            $rules = [
                'id_berita_acara' => 'required',
                'id_jenis_sarana' => 'required',
            ];

            $messages = [
                'id_berita_acara' => ['required' => 'Berita acara is required'],
                'id_jenis_sarana' => ['required' => 'Jenis sarana is required']
            ];
    
            if (!$this->validate($rules, $messages))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            $data = $this->request->getPost();
            $mediaSarana = $this->request->getFile('media_sarana');

            $this->SKModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $data['id_jenis_inventaris']    = $id;
            $data['qrcode_secret']  = uniqid();
            // $data['no_sarana']  = $data['no_senjata'];
            // unset($data['no_senjata']);
            $isAdded = $this->SKModel->createData($data, true);
            if (!$isAdded)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            $now = Time::now();
            // print_r($mediaSarana ? 'true' : 'false');die();
            if ($mediaSarana) {

                $filename   = $now->toLocalizedString('yyyyMMdd_HHmmss');
                $filename   .= '_berita_acara';
                $filename   .= '.'.$mediaSarana->getExtension();
                
                $dataMedia['file_full_path'] = 'uploads/beritaacara/'.$filename;
                $dataMedia['file_origin_name'] = $mediaSarana->getClientName();
                $dataMedia['file_extension'] = $mediaSarana->getExtension();
                $dataMedia['file_size'] = $mediaSarana->getSize();
                $dataMedia['file_mime_type'] = $mediaSarana->getMimeType();

                $filepath = ROOTPATH.'../public/uploads/berita_acara/';
                $mediaSarana->move($filepath, $filename);

                $insertedId = $this->SKModel->createMediaData($dataMedia, true);
                $dataSK['id_media'] = $insertedId;
                $this->SKModel->updateData($isAdded, $dataSK);
            }
    
            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_CREATED,
                    'message'   => 'Data telah ditambahkan!'
                ])
                ->setStatusCode(ResponseInterface::HTTP_CREATED);
        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
