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

    public function get($id)
    {
        $data = $this->SKModel->getOne($id);
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $data
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function getByQrCode()
    {
        $qrsecret = $this->request->getGet('qrsecret');
        if (!is_null($qrsecret)) {
            $data = $this->SKModel->getByQR($qrsecret);
                return $this->response
                    ->setJSON([
                        'status'    => ResponseInterface::HTTP_OK,
                        'data'      => $data
                    ])
                    ->setStatusCode(ResponseInterface::HTTP_OK);
        }
    }

    // datatable
    public function datatable()
    {
        $posts = $this->request->getPost();
        if (empty($posts)) {
            $posts = (array) $this->request->getVar();
        }
        $data = $this->SKModel->customDatatable($posts);

        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['id']."\"></div>";
            $row[]      = "
                <div class=\"text-center\">
                    <input type=\"hidden\" name=\"id\" value=\"".$item['id']."\">{$num}.
                    <input type=\"hidden\" name=\"id_berita_acara\" value=\"".$item['id_berita_acara']."\">
                    <input type=\"hidden\" name=\"judul_berita_acara\" value=\"".$item['judul_berita_acara']."\">
                    <input type=\"hidden\" name=\"nomor_berita_acara\" value=\"".$item['nomor_berita_acara']."\">
                    <input type=\"hidden\" name=\"id_jenis_sarana\" value=\"".$item['id_jenis_sarana']."\">
                    <input type=\"hidden\" name=\"nama_jenis_sarana\" value=\"".$item['nama_jenis_sarana']."\">
                    <input type=\"hidden\" name=\"id_merk_sarana\" value=\"".$item['id_merk_sarana']."\">
                    <input type=\"hidden\" name=\"nama_merk_sarana\" value=\"".$item['nama_merk_sarana']."\">
                    <input type=\"hidden\" name=\"media_file_full_path\" value=\"".$item['media_file_full_path']."\">
                    <input type=\"hidden\" name=\"media_file_extension\" value=\"".$item['media_file_extension']."\">
                    <input type=\"hidden\" name=\"qrcode_secret\" value=\"".$item['qrcode_secret']."\">
                </div>
            ";
            $row[]      = $item['nomor_sarana'] ?? '-';
            $row[]      = $item['nomor_bpsa'] ?? '-';
            $row[]      = $item['nama'] ?? '-';
            $row[]      = $item['merk'] ?? '-';
            $row[]      = $item['kondisi'] ?? '-';
            $row[]      = $item['keterangan'] ?? '-';
            $row[]      = $this->buildCustomButtonActions($item['id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->SKModel->customCountTotalDatatable($posts);
        $output['recordsFiltered']  = $this->SKModel->customCountTotalFilteredDatatable($posts);
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
                'id_berita_acara' => 'required',
                'id_jenis_sarana' => 'required',
                'id_merk_sarana'    => 'required',
                'id_jenis_inventaris'   => 'required',
                'satuan'    => 'required',
                'jumlah'    => 'required',
                'nomor_sarana'  => 'required',
                'nomor_bpsa'    => 'required',
                'kondisi'   => 'required|in_list[baik,rusak]',
                'keterangan'    => 'required'
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

            $data['qrcode_secret']  = uniqid();
            $isCreated = $this->SKModel->createData($data, true);
            if (!$isCreated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            if ($media) {
                $filename   = Time::now()->toLocalizedString('yyyyMMdd_HHmmss');
                $filename   .= '_sarana_keamanan';
                $filename   .= '.'.$media->getExtension();
                
                $dataMedia['file_full_path']    = 'uploads/sarana_keamanan/'.$filename;
                $dataMedia['file_origin_name']  = $media->getClientName();
                $dataMedia['file_extension']    = $media->getExtension();
                $dataMedia['file_size']         = $media->getSize();
                $dataMedia['file_mime_type']    = $media->getMimeType();

                $filepath = ROOTPATH.'../public/uploads/sarana_keamanan/';
                $media->move($filepath, $filename);

                $insertedId = $this->SKModel->createMediaData($dataMedia, true);
                $dataSK['id_media'] = $insertedId;
                $this->SKModel->updateData($isCreated, $dataSK);
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

    // update
    public function update($id)
    {
        try {            
            if (!$this->validate([
                'id_berita_acara' => 'required',
                'id_jenis_sarana' => 'required',
                'id_merk_sarana'    => 'required',
                'id_jenis_inventaris'   => 'required',
                'satuan'    => 'required',
                'jumlah'    => 'required',
                'nomor_sarana'  => 'required',
                'nomor_bpsa'    => 'required',
                'kondisi'   => 'required|in_list[baik,rusak]',
                'keterangan'    => 'required'
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

            $data['qrcode_secret']  = uniqid();
            $isUpdated = $this->SKModel->updateData($id, $data);
            if (!$isUpdated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            if ($media) {
                $filename   = Time::now()->toLocalizedString('yyyyMMdd_HHmmss');
                $filename   .= '_sarana_keamanan';
                $filename   .= '.'.$media->getExtension();
                
                $dataMedia['file_full_path']    = 'uploads/sarana_keamanan/'.$filename;
                $dataMedia['file_origin_name']  = $media->getClientName();
                $dataMedia['file_extension']    = $media->getExtension();
                $dataMedia['file_size']         = $media->getSize();
                $dataMedia['file_mime_type']    = $media->getMimeType();

                $filepath = ROOTPATH.'../public/uploads/sarana_keamanan/';
                $media->move($filepath, $filename);

                $insertedId = $this->SKModel->createMediaData($dataMedia, true);
                $this->SKModel->updateData($id, [
                    'id_media' => $insertedId
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
            if (!$this->SKModel->isExist((int) $id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );

            $this->SKModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $isDeleted = $this->SKModel->deleteData($id);
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
                
            $this->SKModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $affectedRows = $this->SKModel->deleteMultipleData($ids);
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

    protected function buildCustomButtonActions($id)
    {
        $showUrl = site_url('dashboard/sarana_keamanan/'.$id.'/show');
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-warning btn-xs mr-2\" data-item-id=\"$id\"><i class=\"fas fa-qrcode mr-1\"></i>QR Code</button>
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'lihat_senjata', 'width=800, height=1200')\" class=\"btn btn-primary btn-xs mr-2\"><i class=\"fas fa-eye mr-1\"></i> Detail</a>
                    <button type=\"button\" class=\"btn btn-info btn-xs mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt mr-1\"></i>Edit</button>
                    <button type=\"button\" class=\"btn btn-danger btn-xs\" data-item-id=\"$id\"><i class=\"fas fa-trash mr-1\"></i>Hapus</button>
                </div>";
    }
}
