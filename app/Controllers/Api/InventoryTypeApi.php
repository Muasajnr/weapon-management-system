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
            $row[]      = "{$num}.";
            $row[]      = "{$item->name}";
            $row[]      = "{$item->desc}";
            $isActive   = $item->is_active ? 'checked' : '';
            $row[]      = "<div class=\"text-center\"><input type=\"checkbox\" name=\"is_active\" data-inventory-type-id=\"$item->id\" $isActive></div>";
            $row[]      = "{$item->created_at}";
            $row[]      = 'edit|delete';

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
        $isActive = $this->request->getRawInput('is_active');
        
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
