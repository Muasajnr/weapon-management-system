<?php

namespace App\Modules\APIs\BeritaAcara\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\BeritaAcara\Models\BeritaAcaraModel;
use CodeIgniter\HTTP\ResponseInterface;

class DefaultController extends ApiController
{

    private $beritaAcaraModel;

    
    public function __construct()
    {
        parent::__construct();
        $this->beritaAcaraModel = new BeritaAcaraModel();
    }
    

    public function index()
    {
        $allData = $this->beritaAcaraModel->getAll();
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $allData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->beritaAcaraModel->customDatatables($posts);

        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['id']."\"></div>";
            $row[]      = "<div class=\"text-center\"><input type=\"hidden\" value=\"".$item['id']."\">{$num}.</div>";
            $row[]      = $item['nama'];
            $row[]      = $item['nomor'];
            $row[]      = $item['tanggal'];
            $row[]      = $item['pihak_1_nama'] ?? '-'; // todo: show modal of pihak 1 detail
            $row[]      = $item['pihak_2_nama'] ?? '-'; // show modal of pihak 2 detail
            $row[]      = $item['created_at'];
            $row[]      = $this->buildCustomActionButtons($item['id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->beritaAcaraModel->customCountTotalDatatable($posts);
        $output['recordsFiltered']  = $this->beritaAcaraModel->customCountTotalFilteredDatatable();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function create()
    {
        try {
            if (!$this->request->isAJAX())
                throw new ApiAccessErrorException('Not ajax', ResponseInterface::HTTP_BAD_REQUEST);

            if (!$this->validate([
                'nama'  => 'required',
                'nomor' => 'required',
                'tanggal'   => 'required',

                'pihak_1_nip'   => 'required',
                'pihak_1_nama'  => 'required',
                'pihak_1_pangkat'   => 'required',
                'pihak_1_jabatan'   => 'required',

                'pihak_2_nip'   => 'required',
                'pihak_2_nama'  => 'required',
                'pihak_2_pangkat'   => 'required',
                'pihak_2_jabatan'   => 'required',
            ]))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );

            $data = $this->request->getPost();
            $media = $this->request->getFile('media');

            $this->SKModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            // 


        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(\Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update()
    {
        try {
            
        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(\Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete()
    {
        try {
            
        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(\Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteMultiple()
    {
        try {
            
        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(\Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function buildCustomActionButtons(int $id)
    {
        $showUrl = site_url('dashboard/berita_acara/'.$id.'/detail');
        return "<div class=\"text-center\">
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'lihat_berita_acara', 'width=800, height=1200')\" class=\"btn btn-primary btn-sm mr-2\"><i class=\"fas fa-eye\"></i></a>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }

}
