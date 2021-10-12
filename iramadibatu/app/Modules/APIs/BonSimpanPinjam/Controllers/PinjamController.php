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
            $row[]      = $item['pihak_1_nama'];
            $row[]      = $item['pihak_2_nama'];
            $row[]      = $item['nomor_sarana'].' - '.$item['nama_sarana'].' - '.$item['merk_sarana'];
            $row[]      = $item['pinjam_sarana_jumlah'];
            $row[]      = $item['tanggal_pinjam'];
            $row[]      = $this->buildCustomActionButtons($item['pinjam_sarana_id']);

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

    private function buildCustomActionButtons(int $id)
    {
        $showUrl = site_url('dashboard/pinjam_sarana/'.$id.'/detail');
        return "<div class=\"text-center\">
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'lihat_pinjam_sarana', 'width=800, height=1200')\" class=\"btn btn-primary btn-sm mr-2\"><i class=\"fas fa-eye\"></i></a>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }
    
}
