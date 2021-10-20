<?php

namespace App\Modules\APIs\BonSimpanPinjam\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\BonSimpanPinjam\Models\PinjamModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class PinjamController extends ApiController
{
    
    protected $pinjamModel;

    public function __construct()
    {
        parent::__construct();
        $this->pinjamModel = new PinjamModel();
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->pinjamModel->customDatatables($posts);

        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['pinjam_sarana_id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['pinjam_sarana_id']."\">{$num}.";
            $row[]      = $item['berita_acara_nomor'];
            $row[]      = "<a href=\"javascript:void(0)\" class=\"viewPihak1\">".$item['pihak_1_nama']."</a>";
            $row[]      = "<a href=\"javascript:void(0)\" class=\"viewPihak2\">".$item['pihak_1_nama']."</a>";
            $row[]      = "<a href=\"javascript:void(0)\" class=\"viewSarana\">".$item['nama_sarana']."</a>";
            $row[]      = $item['pinjam_sarana_jumlah'];
            $row[]      = $item['tanggal_pinjam'];
            $row[]      = $this->buildCustomActionButtons($item['pinjam_sarana_id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->pinjamModel->customCountTotalDatatable($posts);
        $output['recordsFiltered']  = $this->pinjamModel->customCountTotalFilteredDatatable();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function create()
    {
        try {
            // print_r($this->request->getVar());die();
            if (!$this->validate([
                'id_berita_acara' => 'required',
                'ids_pinjam' => 'required'
            ]))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            $reqData = $this->request->getVar();

            $this->pinjamModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );
            $allData = [];

            $idsPinjam = explode('|', $reqData->ids_pinjam);
            foreach($idsPinjam as $rawItem) {
                $item = substr(substr($rawItem, 1), 0, -1);
                $resItem = explode(',', $item);
                $data['id_berita_acara'] = $reqData->id_berita_acara;
                $data['id_sarana_keamanan'] = $resItem[0];
                $data['jumlah'] = $resItem[1];

                array_push($allData, $data);
            }
            // print_r($allData);
            // die();
            $isCreated = $this->pinjamModel->createBatch($allData);
            if (!$isCreated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
    
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

    // delete
    public function delete($id)
    {
        try {
            if (!$this->pinjamModel->isExist((int) $id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND
                );

            $this->pinjamModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $isDeleted = $this->pinjamModel->deleteData($id);
            if (!$isDeleted)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Data telah dihapus!'
                ])
                ->setStatusCode(ResponseInterface::HTTP_OK);
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

    // delete multiple
    public function deleteMultiple()
    {
        try {
            if (!$this->request->isAJAX())
                throw new ApiAccessErrorException(
                    'Invalid Request!', 
                    ResponseInterface::HTTP_BAD_REQUEST
                );
            
            if (!$this->validate(['ids' => 'required']))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );

            $ids = $this->request->getVar('ids');
                
            $this->pinjamModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $affectedRows = $this->pinjamModel->deleteMultipleData($ids);
            if ($affectedRows != count($ids))
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Data telah dihapus!'
                ])
                ->setStatusCode(ResponseInterface::HTTP_OK);
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
        $showUrl = site_url('dashboard/pinjam_sarana/'.$id.'/detail');
        return "<div class=\"text-center\">
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'lihat_pinjam_sarana', 'width=800, height=1200')\" class=\"btn btn-primary btn-xs mr-2\"><i class=\"fas fa-eye mr-1\"></i>Detail</a>
                    <button type=\"button\" class=\"btn btn-danger btn-xs\" data-item-id=\"$id\"><i class=\"fas fa-trash mr-1\"></i>Hapus</button>
                </div>";
    }
    
}
