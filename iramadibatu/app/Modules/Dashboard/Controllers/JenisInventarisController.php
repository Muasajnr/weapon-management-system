<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\WebController;

class JenisInventarisController extends WebController
{
    public function index()
    {
        return $this->renderView('pages/master/jenis_inventaris/index', [
            'page_title'    => 'List Jenis Inventaris',
            'page_header_title' => 'List Jenis Inventaris',
            'pages_path'    => [
                'master' => [
                    'url'       => route_to('master'),
                    'active'    => false
                ],
                'jenis inventaris' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
