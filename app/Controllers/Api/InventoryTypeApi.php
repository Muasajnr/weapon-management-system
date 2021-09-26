<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\InventoryTypeModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class InventoryTypeApi extends BaseController
{
    use ResponseTrait;

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
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-inventory-type-id=\"$item->id\"></div>";
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

    public function updateStatus($id)
    {
        $isActive = $this->request->getRawInput()['is_active'];
        
        if (is_null($isActive)) {
            return $this->failValidationErrors('is_active is required!', 'validation failed!');
        } else {
            $inventoryTypeModel = new InventoryTypeModel();
            $updateRes = $inventoryTypeModel->updateStatus($id, $isActive == 'true' ? 1 : 0);
            if (!$updateRes) {
                return $this->fail('Something went wrong!');
            } else {
                return $this->respondUpdated([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Updated successfuly!',
                ], 'Updated successfully!');
            }
        }
    }

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

    public function update($id)
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
                        'message'   => 'Data updated!'
                    ]);
                }
            }
        }
    }

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

    public function purge($id)
    {
        $inventoryTypeModel = new InventoryTypeModel();
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

    private function buildActionButtons($id)
    {
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }

    public function buildStatusSwitch($id, $isActive)
    {
        $isChecked = $isActive ? 'checked' : '';
        return "<div class=\"custom-control custom-switch custom-switch-off-danger custom-switch-on-success\">
                    <input data-inventory-type-id=\"$id\" name=\"is_active\" type=\"checkbox\" class=\"custom-control-input\" id=\"customSwitch3\" $isChecked>
                    <label class=\"custom-control-label\" for=\"customSwitch3\"></label>
                </div>";
    }
}
