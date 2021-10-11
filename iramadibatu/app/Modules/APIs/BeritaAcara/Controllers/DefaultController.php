<?php

namespace App\Modules\APIs\BeritaAcara\Controllers;

use App\Core\ApiController;
use App\Modules\APIs\BeritaAcara\Models\BeritaAcaraModel;
use CodeIgniter\HTTP\ResponseInterface;

class DefaultController extends ApiController
{

    private $beritaAcaraModel;

    
    public function __construct()
    {
        parent::__construct();
        $this->beritaAcaraModel = new BeritaAcaraModel();
    }
    

    public function index()
    {
        $allData = $this->beritaAcaraModel->getAll();
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $allData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->beritaAcaraModel->customDatatables($posts);

        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['id']."\">{$num}.";
            $row[]      = $item['nama'];
            $row[]      = $item['nomor'];
            $row[]      = $item['tanggal'];
            $row[]      = "<strong>Nama : </strong>".$item['pihak_1_nama']."<br><strong>NIP : </strong>".$item['pihak_1_nip'];
            $row[]      = "<strong>Nama : </strong>".$item['pihak_2_nama']."<br><strong>NIP : </strong>".$item['pihak_2_nip'];
            $row[]      = $item['created_at'];
            $row[]      = $this->buildActionButtons($item['id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->beritaAcaraModel->customCountTotalDatatable($posts);
        $output['recordsFiltered']  = $this->beritaAcaraModel->customCountTotalFilteredDatatable();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

}
