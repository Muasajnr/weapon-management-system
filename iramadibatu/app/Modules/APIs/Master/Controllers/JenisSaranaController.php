<?php

namespace App\Modules\APIs\Master\Controllers;

use App\Controllers\BaseController;
use App\Core\ApiController;
use App\Modules\APIs\Master\Models\JenisSaranaModel;
use CodeIgniter\HTTP\ResponseInterface;

class JenisSaranaController extends ApiController
{
    private $JSModel;

    public function __construct()
    {
        parent::__construct();
        $this->JSModel   = new JenisSaranaModel();
    }

    public function index()
    {
        $allData = $this->JSModel->getAll();
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $allData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    /**datatables */
    public function datatables()
    {
        $posts      = $this->request->getPost();
        $data       = $this->JSModel->datatable($posts);
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
        $output['recordsTotal']     = $this->JSModel->countDatatableData($posts);
        $output['recordsFiltered']  = $this->JSModel->countDatatableFilteredData();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
