<?php

namespace App\Controllers\Api;

use App\Core\ApiController;
use App\Models\FirearmModel;
use CodeIgniter\HTTP\ResponseInterface;

class FirearmStockController extends ApiController
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

        $firearmModel       = new FirearmModel();
        $data               = $firearmModel->getDatatablesForStok($searchQuery['value'], $start, $length, $order);
        $recordsTotal       = $firearmModel->getTotalRecordsForStock($searchQuery['value'], $order);
        $recordsFiltered    = $firearmModel->getTotalFilteredRecordsForStock();

        $num = $start;
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "{$num}.";
            $row[]      = "{$item->firearms_types_name}";
            $row[]      = "{$item->stock}";
            $row[]      = "{$item->borrowed_count}";
            $stockStatus = ($item->stock < 10 ? 'danger' : ($item->stock < 50 ? 'warning' : 'success'));
            $row[]      = "<span class=\"badge badge-$stockStatus\">{$item->stock_status}</span>";
            $row[]      = $this->buildCustomActionButtons($item->firearms_types_id);

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

    private function buildCustomActionButtons(int $id)
    {
        return "<div class=\"text-center\">
            <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i>&nbsp;&nbsp;detail</button>
        </div>";
    }
}
