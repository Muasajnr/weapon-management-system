<?php

namespace App\Controllers\Api;

use App\Core\ApiController;
use App\Models\FirearmModel;
use CodeIgniter\HTTP\ResponseInterface;

class FirearmController extends ApiController
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
        $data               = $firearmModel->getDatatables($searchQuery['value'], $start, $length, $order);
        $recordsTotal       = $firearmModel->getTotalRecords($searchQuery['value'], $order);
        $recordsFiltered    = $firearmModel->getTotalFilteredRecords();
        // print_r($data);die();
        $num = $start;
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"$item->firearm_id\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"$item->firearm_id\">{$num}.";
            $row[]      = "{$item->inventory_type}";
            $row[]      = "{$item->firearm_type}";
            $row[]      = "{$item->firearm_brand}";
            $row[]      = "{$item->firearm_number}";
            $row[]      = "{$item->bpsa_number}";
            $row[]      = "{$item->condition}";
            $row[]      = $this->buildActionButtons($item->firearm_id);

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
}
