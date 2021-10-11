<?php

namespace App\Modules\APIs\DistribusiSarana\Controllers;

use App\Core\ApiController;
use App\Modules\APIs\DistribusiSarana\Models\DistribusiModel;
use CodeIgniter\HTTP\ResponseInterface;

class DefaultController extends ApiController
{
    protected $distribusiModel;

    public function __construct()
    {
        parent::__construct();
        $this->distribusiModel = new DistribusiModel();
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->distribusiModel->customDatatables($posts);

        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['distribusi_sarana_id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['distribusi_sarana_id']."\">{$num}.";
            $row[]      = $item['berita_acara_nomor'];
            $row[]      = "<strong>Nama : </strong>".$item['pihak_1_nama']."<br><strong>NIP : </strong>".$item['pihak_1_nip'];
            $row[]      = "<strong>Nama : </strong>".$item['pihak_2_nama']."<br><strong>NIP : </strong>".$item['pihak_2_nip'];
            $row[]      = "<strong>Nomor : </strong>".$item['nomor_sarana']."<br><strong>Nama : </strong>".$item['nama_sarana']."<br><strong>Merk : </strong>".$item['merk_sarana'];
            $row[]      = $item['distribusi_sarana_jumlah'];
            $row[]      = $item['distribusi_sarana_lokasi'];
            $row[]      = $item['distribusi_sarana_tanggal'];
            $row[]      = $this->buildActionButtons($item['distribusi_sarana_id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->distribusiModel->customCountTotalDatatable($posts);
        $output['recordsFiltered']  = $this->distribusiModel->customCountTotalFilteredDatatable();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
