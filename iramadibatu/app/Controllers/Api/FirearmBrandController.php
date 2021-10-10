<?php

namespace App\Controllers\Api;

use App\Core\ApiController;
use App\Models\FirearmBrandModel;
use CodeIgniter\HTTP\ResponseInterface;

class FirearmBrandController extends ApiController
{
    public function index()
    {
        $firearmBrandModel = new FirearmBrandModel();
        return $this->respond([
            'status'    => ResponseInterface::HTTP_OK,
            'data'      => $firearmBrandModel->findAll(),
        ], ResponseInterface::HTTP_OK);
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

        $firearmBrandModel  = new FirearmBrandModel();
        $data               = $firearmBrandModel->getDatatables($searchQuery['value'], $start, $length, $order);
        $recordsTotal       = $firearmBrandModel->getTotalRecords($searchQuery['value'], $order);
        $recordsFiltered    = $firearmBrandModel->getTotalFilteredRecords();

        $num = $start;
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"$item->id\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"$item->id\">{$num}.";
            $row[]      = "{$item->name}";
            $row[]      = "{$item->desc}";
            $row[]      = $this->buildStatusSwitch($item->id, $item->is_active);
            $row[]      = "{$item->created_at}";
            $row[]      = $this->buildActionButtons($item->id);

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

    /******************** insert **********************/
    public function create()
    {
        if (!$this->request->isAJAX())
            return $this->fail('Invalid request!');
        
        $rules      = ['name' => 'required', 'desc' => 'required', 'is_active' => 'required'];
        $messages   = [
            'name'      => ['required' => 'name is required'],
            'desc'      => ['required' => 'desc is required'],
            'is_active' => ['required' => 'is_active is required'],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
        } else {
            $data = $this->request->getVar();
            $firearmBrandModel = new FirearmBrandModel();
            $isAdded = $firearmBrandModel->createNew((array) $data);
            if (!$isAdded) {
                return $this->fail('Something went wrong!');
            } else {
                return $this->respondCreated([
                    'status'    => ResponseInterface::HTTP_CREATED,
                    'message'   => 'Data telah ditambahkan!'
                ]);
            }
        }
    }

    /******************** update **********************/
    public function updateStatus($id)
    {
        if (!$this->request->isAJAX())
            return $this->fail('Invalid request!');

        $rules      = ['is_active' => 'required'];
        $messages   = ['is_active' => ['required' => 'is_active is required']];
        if (!$this->validate($rules, $messages))
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');

        $firearmBrandModel = new FirearmBrandModel();
        if (!$firearmBrandModel->isExist((int) $id))
            return $this->failNotFound('Data not found!');

        $reqData = $this->request->getVar();
        $updateRes = $firearmBrandModel->updateStatus($id, $reqData->is_active);
        if (!$updateRes)
            return $this->fail('Something went wrong!');
        
        return $this->respondUpdated([
            'status'    => ResponseInterface::HTTP_OK,
            'message'   => 'Data telah diupdate!',
        ], 'Data telah diupdate!');
    }

    public function update($id)
    {
        if (!$this->request->isAJAX())
            return $this->fail('Invalid request!');
        
        $rules      = ['name' => 'required', 'desc' => 'required', 'is_active' => 'required'];
        $messages   = [
            'name'      => ['required' => 'name is required'],
            'desc'      => ['required' => 'desc is required'],
            'is_active' => ['required' => 'is_active is required'],
        ];

        if (!$this->validate($rules, $messages))
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
        
        $firearmBrandModel = new FirearmBrandModel();
        $data = $firearmBrandModel->getOne((int)$id);

        if (!$data)
            return $this->failNotFound();
        
        $reqData = $this->request->getVar();
        $isUpdated = $firearmBrandModel->updateData((int)$id, (array) $reqData);
        if (!$isUpdated)
            return $this->fail('Something went wrong!');
        
        return $this->respondUpdated([
            'status'    => ResponseInterface::HTTP_OK,
            'message'   => 'Data telah diupdate!'
        ]);
    }

    /******************** delete **********************/
    public function delete($id)
    {
        $firearmBrandModel = new FirearmBrandModel();
        if (!$firearmBrandModel->isExist((int) $id))
            return $this->failNotFound('Not found!');

        $isDeleted = $firearmBrandModel->deleteData($id);
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
        
        $firearmBrandModel = new FirearmBrandModel();
        $affectedRows = $firearmBrandModel->deleteMultipleData($ids);
        if ($affectedRows != count($ids))
            return $this->fail('Only some data gets deleted! please contact your administrator.');
        
        return $this->respondDeleted([
            'success'   => ResponseInterface::HTTP_OK,
            'message'   => 'Data yang dipilih telah terhapus!'
        ]);
    }

}
