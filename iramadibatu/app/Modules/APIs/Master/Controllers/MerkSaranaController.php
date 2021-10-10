<?php

namespace App\Modules\APIs\Master\Controllers;

use App\Core\ApiController;
use App\Modules\APIs\Master\Models\MerkSaranaModel;
use CodeIgniter\HTTP\ResponseInterface;

class MerkSaranaController extends ApiController
{
    private $MSModel;

    public function __construct()
    {
        parent::__construct();
        $this->MSModel   = new MerkSaranaModel();
    }
    

    /**datatables */
    public function datatables()
    {
        $posts      = $this->request->getPost();
        $data       = $this->MSModel->datatable($posts);
        $resData    = [];

        $num = $posts['start'];
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['id']."\">{$num}.";
            $row[]      = $item['name'];
            $row[]      = $item['desc'];
            $row[]      = $this->buildStatusSwitch($item['id'], $item['is_active']);
            $row[]      = $item['created_at'];
            $row[]      = $this->buildActionButtons($item['id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->MSModel->countDatatableData($posts);
        $output['recordsFiltered']  = $this->MSModel->countDatatableFilteredData();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
