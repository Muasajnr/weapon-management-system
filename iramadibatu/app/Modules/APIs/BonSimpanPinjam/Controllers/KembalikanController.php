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
        
        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['kembalikan_sarana_id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['kembalikan_sarana_id']."\">{$num}.";
            $row[]      = $item['berita_acara_nomor'];
            $row[]      = $item['pihak_1_nama'];
            $row[]      = $item['pihak_2_nama'];
            $row[]      = $item['nomor_sarana'].' - '.$item['nama_sarana'].' - '.$item['merk_sarana'];
            $row[]      = $item['kembalikan_sarana_jumlah'];
            $row[]      = $item['kembalikan_sarana_tanggal'];
            $row[]      = $this->buildCustomActionButtons($item['kembalikan_sarana_id']);

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

    private function buildCustomActionButtons(int $id)
    {
        $showUrl = site_url('dashboard/kembalikan_sarana/'.$id.'/detail');
        return "<div class=\"text-center\">
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'lihat_pinjam_sarana', 'width=800, height=1200')\" class=\"btn btn-primary btn-sm mr-2\"><i class=\"fas fa-eye mr-1\"></i> Detail</a>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash mr-1\"></i>Hapus</button>
                </div>";
    }
}
