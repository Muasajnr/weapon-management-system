<?php

namespace App\Controllers\Api;

use App\Core\ApiController;
use App\Models\DocumentModel;
use CodeIgniter\HTTP\ResponseInterface;

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

    private function buildCustomActionButtons(int $id)
    {
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-file\"></i></button>
                    <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }
}
