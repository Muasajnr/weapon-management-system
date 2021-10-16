<?php

namespace App\Modules\APIs\BeritaAcara\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\BeritaAcara\Models\BeritaAcaraModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

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

    // datatable
    public function datatables()
    {
        $posts = $this->request->getPost();
        if (empty($posts)) {
            $posts = $this->request->getVar();
            $posts = (array) $posts;
        }
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

    // create
    public function create()
    {
        try {
            if (!$this->validate([
                'nama'  => 'required',
                'nomor' => 'required',
                'tanggal'   => 'required',
                'id_pihak_1'    => 'required',
                'id_pihak_2'    => 'required',
            ]))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );

            $data = $this->request->getPost();
            $media = $this->request->getFile('media');

            $this->beritaAcaraModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $isCreated = $this->beritaAcaraModel->createData($data, true);
            if (!$isCreated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            $now = Time::now();
            if ($media) {
                $filename   = $now->toLocalizedString('yyyyMMdd_HHmmss');
                $filename   .= '_berita_acara';
                $filename   .= '.'.$media->getExtension();
                
                $dataMedia['file_full_path'] = 'uploads/berita_acara/'.$filename;
                $dataMedia['file_origin_name'] = $media->getClientName();
                $dataMedia['file_extension'] = $media->getExtension();
                $dataMedia['file_size'] = $media->getSize();
                $dataMedia['file_mime_type'] = $media->getMimeType();

                $filepath = ROOTPATH.'../public/uploads/berita_acara/';
                $media->move($filepath, $filename);

                $mediaCreatedId = $this->beritaAcaraModel->createMediaData($dataMedia, true);
                $this->beritaAcaraModel->updateData($isCreated, [
                    'id_media'  => $mediaCreatedId
                ]);
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
        } catch(\Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // update
    public function update($id)
    {
        try {
            if (!$this->validate([
                'nama'  => 'required',
                'nomor' => 'required',
                'tanggal'   => 'required',
                'id_pihak_1'    => 'required',
                'id_pihak_2'    => 'required',
            ]))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );

            $data = $this->request->getPost();
            $media = $this->request->getFile('media');

            $this->beritaAcaraModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $isUpdated = $this->beritaAcaraModel->updateData($id, (array)$data);
            if (!$isUpdated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );

            if ($media) {
                $filename   = Time::now()->toLocalizedString('yyyyMMdd_HHmmss');
                $filename   .= '_berita_acara';
                $filename   .= '.'.$media->getExtension();
                
                $dataMedia['file_full_path'] = 'uploads/berita_acara/'.$filename;
                $dataMedia['file_origin_name'] = $media->getClientName();
                $dataMedia['file_extension'] = $media->getExtension();
                $dataMedia['file_size'] = $media->getSize();
                $dataMedia['file_mime_type'] = $media->getMimeType();

                $filepath = ROOTPATH.'../public/uploads/berita_acara/';
                $media->move($filepath, $filename);

                $mediaCreatedId = $this->beritaAcaraModel->createMediaData($dataMedia, true);
                $this->beritaAcaraModel->updateData($id, [
                    'id_media'  => $mediaCreatedId
                ]);
            }

            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_CREATED,
                    'message'   => 'Data telah diperbaharui!'
                ])
                ->setStatusCode(ResponseInterface::HTTP_CREATED);
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

    // delete
    public function delete($id)
    {
        try {
            if (!$this->beritaAcaraModel->isExist((int) $id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );

            $this->beritaAcaraModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $isDeleted = $this->beritaAcaraModel->deleteData($id);
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
                
            $this->beritaAcaraModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $affectedRows = $this->beritaAcaraModel->deleteMultipleData($ids);
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
        $showUrl = site_url('dashboard/berita_acara/'.$id.'/detail');
        return "<div class=\"text-center\">
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'lihat_berita_acara', 'width=800, height=1200')\" class=\"btn btn-primary btn-sm mr-2\"><i class=\"fas fa-eye\"></i></a>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }

}
