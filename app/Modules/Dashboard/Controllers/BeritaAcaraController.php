<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\WebController;
use App\Modules\Api\Models\BeritaAcaraModel;

class BeritaAcaraController extends WebController
{
    public function index()
    {
        return $this->renderView('pages/berita_acara/index', [
            'page_title'    => 'List Berita Acara'
        ]);
    }

    public function show($id)
    {
        $beritaAcaraModel = new BeritaAcaraModel();
        $data = $beritaAcaraModel->getOne($id);

        return $this->renderView('pages/berita_acara/show', [
            'page_title'    => 'Detail Berita Acara',
            'data'          => (array)$data
        ]);
    }
}
