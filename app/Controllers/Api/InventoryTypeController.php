<?php

namespace App\Controllers\Api;

use App\Core\ApiController;
use App\Models\InventoryTypeModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryTypeController extends ApiController
{

    use ResponseTrait;

    /******************** get **********************/
    public function index()
    {
        $inventoryTypeModel = new InventoryTypeModel();
        return $this->respond([
            'status'    => ResponseInterface::HTTP_OK,
            'data'      => $inventoryTypeModel->findAll(),
        ], ResponseInterface::HTTP_OK);
    }

    public function getOneData($id)
    {
        $inventoryTypeModel = new InventoryTypeModel();
        $data = $inventoryTypeModel->getOne($id);

        if (!$data)
            return $this->failNotFound();
        else
            return $this->respond([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $data
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

        $inventoryTypeModel = new InventoryTypeModel();
        $data               = $inventoryTypeModel->getDatatables($searchQuery['value'], $start, $length, $order);
        $recordsTotal       = $inventoryTypeModel->getTotalRecords($searchQuery['value'], $order);
        $recordsFiltered    = $inventoryTypeModel->getTotalFilteredRecords();

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
        $rules = [
            'name'      => 'required',
            'desc'      => 'required',
            'is_active' => 'required'
        ];

        $messages = [
            'name' => [
                'required' => 'name is required',
            ],
            'desc' => [
                'required' => 'desc is required',
            ],
            'is_active' => [
                'required' => 'is_active is required',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
        } else {
            $data = $this->request->getVar();
            $inventoryTypeModel = new InventoryTypeModel();
            $isAdded = $inventoryTypeModel->createNew((array) $data);
            if (!$isAdded) {
                return $this->fail('Something went wrong!');
            } else {
                return $this->respondCreated([
                    'status'    => ResponseInterface::HTTP_CREATED,
                    'message'   => 'Data inserted!'
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

        if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
        } else {
            $reqData = $this->request->getVar();

            $inventoryTypeModel = new InventoryTypeModel();
            if (!$inventoryTypeModel->isExist((int)$id))
                return $this->failNotFound('Data not found!');

            $updateRes = $inventoryTypeModel->updateStatus($id, $reqData->is_active);
            if (!$updateRes)
                return $this->fail('Something went wrong!');
            
            return $this->respondUpdated([
                'status'    => ResponseInterface::HTTP_OK,
                'message'   => 'Updated successfuly!',
            ], 'Updated successfully!');
        }
    }

    public function update($id)
    {
        if (!$this->request->isAJAX())
            return $this->fail('Invalid request!');
        
        $rules      = ['name' => 'required', 'desc' => 'required', 'is_active' => 'required'];
        $messages   = [
            'name'      => ['required' => 'name is required'],
            'desc'      => ['required' => 'desc is required'],
            'is_active' => ['required' => 'is_active is required']
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
        } else {
            $inventoryTypeModel = new InventoryTypeModel();
            $data = $inventoryTypeModel->getOne($id);

            if (!$data)
                return $this->failNotFound();
            else {
                $reqData = $this->request->getVar();
                $isUpdated = $inventoryTypeModel->updateData($id, (array) $reqData);
                if (!$isUpdated) {
                    return $this->fail('Something went wrong!');
                } else {
                    return $this->respondUpdated([
                        'status'    => ResponseInterface::HTTP_OK,
                        'message'   => 'Data telah diupdate!'
                    ]);
                }
            }
        }
    }

    /******************** delete **********************/
    public function delete($id)
    {
        $inventoryTypeModel = new InventoryTypeModel();
        if (!$inventoryTypeModel->isExist((int) $id)) {
            return $this->failNotFound('Not found!');
        }

        $isDeleted = $inventoryTypeModel->deleteData($id);
        if (!$isDeleted) {
            return $this->fail('Failed to delete! please contact your administrator.');
        } else {
            return $this->respondDeleted([
                'success'   => ResponseInterface::HTTP_OK,
                'message'   => 'Data telah dihapus!'
            ]);
        }
    }

    public function deleteMultiple()
    {
        $ids = $this->request->getRawInput('ids')['ids'];
        
        $inventoryTypeModel = new InventoryTypeModel();
        $affectedRows = $inventoryTypeModel->deleteMultipleData($ids);
        if ($affectedRows != count($ids)) {
            return $this->fail('Only some data gets deleted! please contact your administrator.');
        } else {
            return $this->respondDeleted([
                'success'   => ResponseInterface::HTTP_OK,
                'message'   => 'Data yang dipilih telah terhapus!'
            ]);
        }
    }

    /******************** purge **********************/
    public function purge($id)
    {
        $inventoryTypeModel = new InventoryTypeModel();
    }
}
