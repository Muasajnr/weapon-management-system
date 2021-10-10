<?php

namespace App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Core\WebController;

class MerkSaranaController extends WebController
{
    public function index()
    {
        return $this->renderView('pages/master/merk_sarana/index', [
            'page_title'    => 'List Merk Sarana',
            'page_header_title' => 'List Merk Sarana',
            'pages_path'    => [
                'master' => [
                    'url'       => route_to('master'),
                    'active'    => false
                ],
                'Merk Sarana' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
