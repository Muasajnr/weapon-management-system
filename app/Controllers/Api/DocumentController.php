<?php

namespace App\Controllers\Api;

use App\Core\ApiController;
use App\Models\DocumentModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class DocumentController extends ApiController
{
    public function index()
    {
        //
    }

    /******************** datatable **********************/
    public function datatables()
    {
        $draw               = $this->request->getPost('draw');
        $searchQuery        = $this->request->getPost('search');
        $length             = $this->request->getPost('length');
        $start              = $this->request->getPost('start');
        $order              = $this->request->getPost('order') ?? [];

        $resData            = [];

        $documentModel       = new DocumentModel();
        $data               = $documentModel->getDatatables($searchQuery['value'], $start, $length, $order);
        $recordsTotal       = $documentModel->getTotalRecords($searchQuery['value'], $order);
        $recordsFiltered    = $documentModel->getTotalFilteredRecords();

        $num = $start;
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"$item->id\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"$item->id\">{$num}.";
            $row[]      = "{$item->doc_number}";
            $row[]      = "{$item->doc_name}";
            $row[]      = "{$item->doc_date}";
            $docTypeBadge = $item->doc_type == 'borrowing' ? 'info' : ($item->doc_type == 'returning' ? 'warning' : 'danger');
            $docTypeText = $item->doc_type == 'borrowing' ? 'peminjaman' : ($item->doc_type == 'returning' ? 'pengembalian' : 'danger');
            $row[]      = "<span class=\"badge badge-$docTypeBadge\">{$docTypeText}</span>";
            $row[]      = "{$item->created_at}";
            $row[]      = $this->buildCustomActionButtons($item->id);

            $resData[] = $row;
        }

        $output = [
            'draw'  => $draw,
            'recordsTotal'  => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'  => $resData,
        ];

        return $this->respond($output, ResponseInterface::HTTP_OK);
    }

    /** create */
    public function create()
    {
        try {
            $rules      = [
                'doc_name'      => 'required',
                'doc_number'    => 'required',
                'doc_date'      => 'required',
                'doc_media'     => 'uploaded[doc_media]|mime_in[doc_media,image/png,image/jpeg,application/pdf]|max_size[doc_media, 1536]',
                'doc_type'      => 'required',
            ];
            $messages   = [
                'doc_name'      => ['required' => 'doc_name is required'],
                'doc_number'    => ['required' => 'doc_number is required'],
                'doc_date'      => ['required' => 'doc_date is required'],
                'doc_media'     => [
                    'uploaded'  => 'doc_media wasn\'t uploaded',
                    'mime_in'   => 'doc_media invalid mime',
                    'max_size'  => 'file size is too big', 
                ],
                'doc_type'      => ['required' => 'doc_type is required'],
            ];
            
            if (!$this->validate($rules, $messages))
                return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
            
            $docName    = $this->request->getPost('doc_name');
            $docNumber  = $this->request->getPost('doc_number');
            $docDate    = $this->request->getPost('doc_date');
            
            $docMediaFile   = $this->request->getFile('doc_media');

            $now = Time::now();

            $filename   = 'document_';
            $filename   .= $now->toLocalizedString('yyyyMMdd_HHmmss');
            $filename   .= '.'.$docMediaFile->getExtension();
            $docMediaPath = 'uploads/documents/'.$filename;
            
            $docType    = $this->request->getPost('doc_type');
            
            $uploadedMediaName = $docMediaFile->getName();
            $uploadedMediaExt = $docMediaFile->getClientExtension();

            $data = [
                'doc_name'      => $docName,
                'doc_number'    => $docNumber,
                'doc_date'      => $docDate,
                'doc_media'     => $docMediaPath,
                'doc_type'      => $docType,
                'uploaded_media_name'   => $uploadedMediaName,
                'uploaded_media_ext'   => $uploadedMediaExt,
            ];
            
            $documentModel = new DocumentModel();
            $isAdded = $documentModel->createNew($data);
            if (!$isAdded) {
                return $this->fail('Something went wrong!');
            } else {
                // upload a file
                $filepath = ROOTPATH.'public/uploads/documents/';
                $docMediaFile->move($filepath, $filename);

                return $this->respondCreated([
                    'status'    => ResponseInterface::HTTP_CREATED,
                    'message'   => 'Data telah ditambahkan!'
                ]);
            }
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /** update */
    public function update($id)
    {
        $rules      = [
            'doc_name'      => 'required',
            'doc_number'    => 'required',
            'doc_date'      => 'required',
            'doc_type'      => 'required',
        ];
        $messages   = [
            'doc_name'      => ['required' => 'doc_name is required'],
            'doc_number'    => ['required' => 'doc_number is required'],
            'doc_date'      => ['required' => 'doc_date is required'],
            'doc_type'      => ['required' => 'doc_type is required'],
        ];

        if (!$this->validate($rules, $messages))
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
        
        $docModel = new DocumentModel();
        $data = $docModel->getOne((int)$id);

        if (!$data)
            return $this->failNotFound();

        $docName    = $this->request->getPost('doc_name');
        $docNumber  = $this->request->getPost('doc_number');
        $docDate    = $this->request->getPost('doc_date');
        $docType    = $this->request->getPost('doc_type');
        
        $now = Time::now();

        $docMediaFile   = $this->request->getFile('doc_media');
        if (!$docMediaFile) {
            $reqData = [
                'doc_name'      => $docName,
                'doc_number'    => $docNumber,
                'doc_date'      => $docDate,
                'doc_media'     => $data->doc_media,
                'doc_type'      => $docType,
                'uploaded_media_name'   => $data->uploaded_media_name,
                'uploaded_media_ext'   => $data->uploaded_media_ext,
                'updated_at'    => $now->toDateTimeString(),
            ];

            $isUpdated = $docModel->updateData((int)$id, $reqData);
            if (!$isUpdated)
                return $this->fail('Something went wrong!');

            return $this->respondUpdated([
                'status'    => ResponseInterface::HTTP_OK,
                'message'   => 'Data telah diupdate!'
            ]);
        } else {
            $filename   = 'document_';
            $filename   .= $now->toLocalizedString('yyyyMMdd_HHmmss');
            $filename   .= '.'.$docMediaFile->getExtension();
            $docMediaPath = 'uploads/documents/'.$filename;

            $uploadedMediaName = $docMediaFile->getName();
            $uploadedMediaExt = $docMediaFile->getClientExtension();

            $reqData = [
                'doc_name'      => $docName,
                'doc_number'    => $docNumber,
                'doc_date'      => $docDate,
                'doc_media'     => $docMediaPath,
                'doc_type'      => $docType,
                'uploaded_media_name' => $uploadedMediaName,
                'uploaded_media_ext' => $uploadedMediaExt,
                'updated_at'    => $now->toDateTimeString(),
            ];
            
            $isUpdated = $docModel->updateData((int)$id, $reqData);
            if (!$isUpdated)
                return $this->fail('Something went wrong!');

            /** delete old files */
            if (file_exists(ROOTPATH.'public/'.$data->doc_media))
                unlink(ROOTPATH.'public/'.$data->doc_media);

            $filepath = ROOTPATH.'public/uploads/documents/';
            $docMediaFile->move($filepath, $filename);

            return $this->respondUpdated([
                'status'    => ResponseInterface::HTTP_OK,
                'message'   => 'Data telah diupdate!'
            ]);
        }
    }

    /** delete */
    public function delete($id)
    {
        $docModel = new DocumentModel();
        if (!$docModel->isExist((int) $id))
            return $this->failNotFound('Not found!');

        $isDeleted = $docModel->deleteData($id);
        if (!$isDeleted)
            return $this->fail('Failed to delete! please contact your administrator.');

        return $this->respondDeleted([
            'success'   => ResponseInterface::HTTP_OK,
            'message'   => 'Data telah dihapus!'
        ]);
    }

    public function deleteMultiple()
    {
        if (!$this->request->isAJAX())
            return $this->fail('Invalid request!');
        
        $rules      = ['ids' => 'required'];
        $messages   = [
            'ids' => ['required' => 'ids is required']
        ];
        
        if (!$this->validate($rules, $messages))
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');

        $ids = $this->request->getVar('ids');
        
        $docModel = new DocumentModel();
        $affectedRows = $docModel->deleteMultipleData($ids);
        if ($affectedRows != count($ids))
            return $this->fail('Only some data gets deleted! please contact your administrator.');
        
        return $this->respondDeleted([
            'success'   => ResponseInterface::HTTP_OK,
            'message'   => 'Data yang dipilih telah terhapus!'
        ]);
    }

    /******************** purge **********************/
    public function purge($id)
    {
        $docModel = new DocumentModel();

        // $docData = $docModel->getOne($id);

        // /** delete old files */
        // if (file_exists(ROOTPATH.'public/'.$docData->doc_media))
        //     unlink(ROOTPATH.'public/'.$docData->doc_media);
    }

    private function buildCustomActionButtons(int $id)
    {
        $editUrl = site_url('/dashboard/berita-acara/'.$id.'/edit');
        $showUrl = site_url('dashboard/berita-acara/'.$id.'/show');
        return "<div class=\"text-center\">
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'ShowDocument', 'width=800, height=1200')\" class=\"btn btn-primary btn-sm mr-2\"><i class=\"fas fa-file\"></i></a>
                    <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                    <a href=\"$editUrl\" class=\"btn btn-info btn-sm mr-2\"><i class=\"fas fa-pencil-alt\"></i></a>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }
}
