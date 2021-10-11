<?php

namespace App\Modules\APIs\BonSimpanPinjam\Controllers;

use App\Core\ApiController;
use App\Modules\APIs\BonSimpanPinjam\Models\KembalikanModel;
use CodeIgniter\HTTP\ResponseInterface;

class KembalikanController extends ApiController
{
    protected $kembalikanModel;

    public function __construct()
    {
        parent::__construct();
        $this->kembalikanModel = new KembalikanModel();
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->kembalikanModel->customDatatables($posts);
        // print_r($data);die();
        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['kembalikan_sarana_id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['kembalikan_sarana_id']."\">{$num}.";
            $row[]      = $item['berita_acara_nomor'];
            $row[]      = "<strong>Nama : </strong>".$item['pihak_1_nama']."<br><strong>NIP : </strong>".$item['pihak_1_nip'];
            $row[]      = "<strong>Nama : </strong>".$item['pihak_2_nama']."<br><strong>NIP : </strong>".$item['pihak_2_nip'];
            $row[]      = "<strong>Nomor : </strong>".$item['nomor_sarana']."<br><strong>Nama : </strong>".$item['nama_sarana']."<br><strong>Merk : </strong>".$item['merk_sarana'];
            $row[]      = $item['kembalikan_sarana_jumlah'];
            $row[]      = $item['kembalikan_sarana_tanggal'];
            $row[]      = $this->buildActionButtons($item['kembalikan_sarana_id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->kembalikanModel->customCountTotalDatatable($posts);
        $output['recordsFiltered']  = $this->kembalikanModel->customCountTotalFilteredDatatable();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
