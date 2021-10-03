<?php

namespace App\Controllers\Api;

use App\Core\ApiController;
use App\Models\BorrowingModel;
use CodeIgniter\HTTP\ResponseInterface;

class BorrowingController extends ApiController
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

        $borrowingModel       = new BorrowingModel();
        $data               = $borrowingModel->getDatatables($searchQuery['value'], $start, $length, $order);
        $recordsTotal       = $borrowingModel->getTotalRecords($searchQuery['value'], $order);
        $recordsFiltered    = $borrowingModel->getTotalFilteredRecords();

        $num = $start;
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"$item->id\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"$item->id\">{$num}.";
            $row[]      = "{$item->borrowing_number}";
            $row[]      = $this->buildDocNumberURL($item->doc_id, $item->doc_number);
            $row[]      = "{$item->firearm_number}";
            $row[]      = "{$item->firearm_type}";
            $row[]      = "{$item->firearm_brand}";
            $row[]      = "{$item->desc}";
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

    private function buildCustomActionButtons(int $id)
    {
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }

    private function buildDocNumberURL($docId, $docNumber)
    {
        $hrefUrl = site_url('dashboard/berita-acara/show/'.$docId);

        return "<a href=\"javascript:void(0)\" onclick=\"window.open('$hrefUrl', 'ShowDocument', 'width=800, height=1200')\">$docNumber</a>";
    }
}
