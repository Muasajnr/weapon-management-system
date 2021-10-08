<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\WebController;

class JenisSaranaController extends WebController
{
    public function index()
    {
        return $this->renderView('pages/master/jenis_sarana/index', [
            'page_title'    => 'List Jenis Sarana',
            'page_header_title' => 'List Jenis Sarana',
            'pages_path'    => [
                'master' => [
                    'url'       => route_to('master'),
                    'active'    => false
                ],
                'Jenis Sarana' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
