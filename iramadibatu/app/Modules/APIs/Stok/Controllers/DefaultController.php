<?php

namespace App\Modules\APIs\Stok\Controllers;

use App\Core\ApiController;
use App\Modules\APIs\Stok\Models\StokModel;
use CodeIgniter\HTTP\ResponseInterface;

class DefaultController extends ApiController
{
    protected $stokModel;

    public function __construct()
    {
        parent::__construct();
        $this->stokModel = new StokModel();
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->stokModel->customDatatable($posts);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();
        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = $num;
            $row[]      = $item['nama_sarana'];
            $row[]      = $item['stok'];
            $row[]      = $item['sedang_dipinjam'];
            $row[]      = $item['sudah_didistribusi'];
            $row[]      = $item['status_stok'];
            $row[]      = 'status button here';

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->stokModel->customCountTotalDatatable($posts);
        $output['recordsFiltered']  = $this->stokModel->customCountTotalFilteredDatatable();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
