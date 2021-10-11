<?php

namespace App\Modules\APIs\BonSimpanPinjam\Controllers;

use App\Core\ApiController;
use App\Modules\APIs\BonSimpanPinjam\Models\PinjamModel;
use CodeIgniter\HTTP\ResponseInterface;

class PinjamController extends ApiController
{
    
    protected $pinjamModel;

    public function __construct()
    {
        parent::__construct();
        $this->pinjamModel = new PinjamModel();
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->pinjamModel->customDatatables($posts);

        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['pinjam_sarana_id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['pinjam_sarana_id']."\">{$num}.";
            $row[]      = $item['berita_acara_nomor'];
            $row[]      = "<strong>Nama : </strong>".$item['pihak_1_nama']."<br><strong>NIP : </strong>".$item['pihak_1_nip'];
            $row[]      = "<strong>Nama : </strong>".$item['pihak_2_nama']."<br><strong>NIP : </strong>".$item['pihak_2_nip'];
            $row[]      = "<strong>Nomor : </strong>".$item['nomor_sarana']."<br><strong>Nama : </strong>".$item['nama_sarana']."<br><strong>Merk : </strong>".$item['merk_sarana'];
            $row[]      = $item['pinjam_sarana_jumlah'];
            $row[]      = $item['tanggal_pinjam'];
            $row[]      = $this->buildActionButtons($item['pinjam_sarana_id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->pinjamModel->customCountTotalDatatable($posts);
        $output['recordsFiltered']  = $this->pinjamModel->customCountTotalFilteredDatatable();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
    
}
