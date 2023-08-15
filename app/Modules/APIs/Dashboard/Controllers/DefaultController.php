<?php

namespace App\Modules\APIs\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Core\ApiController;
use App\Modules\APIs\Dashboard\Models\DefaultModel;
use CodeIgniter\HTTP\ResponseInterface;

class DefaultController extends ApiController
{

    private $defaultModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->defaultModel = new DefaultModel();
    }
    

    public function index()
    {
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'message'   => 'Nothing here'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function listStok()
    {
        $data = $this->defaultModel->listStok();
        // print_r($data);die();
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'   => $data
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
    public function listDipinjam()
    {
        $data = $this->defaultModel->listDipinjam();
        // print_r($data);die();
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'   => $data
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
    public function summaryData()
    {
        $stok = $this->defaultModel->totalStok();
        $distribusi = $this->defaultModel->totalDidistribusi();
        $pinjam = $this->defaultModel->totalDipinjam();
        $users = $this->defaultModel->totalUsers();

        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'   => [
                    'stok'  => $stok['jumlah'],
                    'distribusi'  => $distribusi['jumlah'],
                    'pinjam'  => $pinjam['jumlah'],
                    'users'  => $users['jumlah'],
                ]
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function stokByJenisInventaris()
    {
        $data = $this->defaultModel->stokByJenisInventaris();
        // print_r($data);die();
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'   => $data
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
