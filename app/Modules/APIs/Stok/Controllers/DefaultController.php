<?php

namespace App\Modules\APIs\Stok\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\Stok\Models\StokModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

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
            $row[]      = "<span class=\"badge badge-primary\">".$item['status_stok']."</span>";

            $showUrl    = site_url("dashboard/stok/".$item['id_nama_sarana']."/detail?stok=".$item['stok']."&dipinjam=".$item['sedang_dipinjam']."&distribusi=".$item["sudah_didistribusi"]);
            $row[]      = "<div class=\"text-center\">
                                <a href=\"javascript:void(0)\" 
                                    onclick=\"window.open('$showUrl', 'ShowStok', 'width=800, height=1200')\" 
                                    class=\"btn btn-primary btn-xs\">
                                    <i class=\"fas fa-eye mr-2\"></i>Lihat Detail
                                </a>
                           </div>";

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

    public function getByJenisSarana()
    {
        try {
            $params = $this->request->getGet();
            $idJenisSarana = $params['id_jenis_sarana'] ?? 0;

            if (!$this->stokModel->checkJenisSarana($idJenisSarana))
                throw new ApiAccessErrorException(
                    'Not Found',
                    ResponseInterface::HTTP_NOT_FOUND,
                );

            $listData['stok_data'] = $this->stokModel->getStokData($idJenisSarana);
            $listData['sedang_dipinjam'] = $this->stokModel->getStokDataByPinjam($idJenisSarana);
            $listData['didistribusi'] = $this->stokModel->getStokDataByDistribusi($idJenisSarana);

            helper('common');

            return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $listData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
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
}
