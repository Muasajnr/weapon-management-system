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

}
