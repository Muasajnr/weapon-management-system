<?php

namespace App\Modules\APIs\BonSimpanPinjam\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\BonSimpanPinjam\Models\KembalikanModel;
use App\Modules\APIs\BonSimpanPinjam\Models\PinjamModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

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
            $row[]      = "<a href=\"javascript:void(0)\" class=\"viewPihak1\">".$item['pihak_1_nama']."</a>";
            $row[]      = "<a href=\"javascript:void(0)\" class=\"viewPihak2\">".$item['pihak_2_nama']."</a>";
            $row[]      = "<a href=\"javascript:void(0)\" class=\"viewSarana\">".$item['nama_sarana']."</a>";
            $row[]      = $item['kembalikan_sarana_jumlah'];
            $row[]      = $item['kembalikan_sarana_tanggal'];
            $row[]      = $this->buildCustomActionButtons($item['kembalikan_sarana_id'], $item['kode'] ?? '');

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

    public function create()
    {
        try {
            // print_r($this->request->getVar());die();
            if (!$this->validate([
                'id_berita_acara' => 'required',
                'kode_peminjaman' => 'required'
            ]))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            $reqData = $this->request->getVar();

            $this->kembalikanModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );
            
            $pinjamModel = new PinjamModel();
            $pinjamSaranaData = $pinjamModel->getByKode($reqData->kode_peminjaman);
            $idsToDelete = [];
            $allData = [];
            foreach($pinjamSaranaData as $itemPinjam) {
                array_push($idsToDelete, $itemPinjam['id']);
                array_push($allData, [
                    'id_berita_acara' => $reqData->id_berita_acara,
                    'id_pinjam_sarana'  => $itemPinjam['id'],
                    'jumlah'    => $itemPinjam['jumlah']
                ]);
            }

            $isCreated = $this->kembalikanModel->createBatch($allData);
            if (!$isCreated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            $pinjamModel->deleteMultipleData($idsToDelete);
            
            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_CREATED,
                    'message'   => 'Data telah ditambahkan!'
                ])
                ->setStatusCode(ResponseInterface::HTTP_CREATED);
        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function buildCustomActionButtons(int $id, string $kode)
    {
        $showUrl = site_url('dashboard/bon_pinjam_sarana/pinjam/detail?kode_peminjaman='.$kode);
        return "<div class=\"text-center\">
                    <a href=\"javascript:void(0)\" onclick=\"window.open('$showUrl', 'lihatKembalikanSarana', 'width=800, height=1200')\" class=\"btn btn-primary btn-xs mr-2\"><i class=\"fas fa-eye mr-1\"></i> Detail</a>
                </div>";
    }
}
