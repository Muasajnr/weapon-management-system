<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\WebController;

class StokController extends WebController
{
    public function index()
    {
        return $this->renderView('pages/stok/index', [
            'page_title'    => 'List Stok',
            'page_header_title' => 'List Stok',
            'pages_path'    => [
                'Stok' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
