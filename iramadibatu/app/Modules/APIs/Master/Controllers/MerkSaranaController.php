<?php

namespace App\Modules\APIs\Master\Controllers;

use App\Controllers\BaseController;
use App\Modules\APIs\Master\Models\MerkSaranaModel;
use CodeIgniter\HTTP\ResponseInterface;

class MerkSaranaController extends BaseController
{
    private $merkSaranaModel;

    public function __construct()
    {
        $this->merkSaranaModel   = new MerkSaranaModel();
    }
    

    /**datatables */
    public function datatables()
    {
        $draw               = $this->request->getPost('draw');
        $searchQuery        = $this->request->getPost('search');
        $length             = $this->request->getPost('length');
        $start              = $this->request->getPost('start');
        $order              = $this->request->getPost('order') ?? [];

        $resData            = [];

        $data                   = $this->merkSaranaModel->getDatatables($searchQuery['value'], $start, $length, $order);
        $recordsTotal           = $this->merkSaranaModel->getTotalRecords($searchQuery['value'], $order);
        $recordsFiltered        = $this->merkSaranaModel->getTotalFilteredRecords();

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
        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    private function buildStatusSwitch($id, $isActive)
    {
        $isChecked = $isActive ? 'checked' : '';
        return "<div class=\"custom-control custom-switch custom-switch-off-danger custom-switch-on-success text-center\">
                    <input data-item-id=\"$id\" name=\"is_active\" type=\"checkbox\" class=\"custom-control-input\" id=\"customSwitch3-$id\" $isChecked>
                    <label class=\"custom-control-label\" for=\"customSwitch3-$id\"></label>
                </div>";
    }

    private function buildActionButtons($id)
    {
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }

}
