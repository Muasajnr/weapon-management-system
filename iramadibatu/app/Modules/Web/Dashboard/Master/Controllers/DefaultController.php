<?php

namespace App\Modules\Web\Dashboard\Master\Controllers;

use App\Core\WebController;

class DefaultController extends WebController
{
    public function __construct()
    {
        parent::__construct(dirname(__FILE__));
    }

    public function index()
    {
        return redirect()->to('dashboard/master/jenis_inventaris');
    }
    

    public function jenisInventaris()
    {
        return $this->renderView('jenis_inventaris/index', [
            'page_title'        => 'Jenis Inventaris',
            'page_header_title' => 'Jenis Inventaris',
            'pages_path'        => [
                'master' => [
                    'url'       => route_to('master'),
                    'active'    => false
                ],
                'jenis inventaris' => [
                    'url'       => '',
                    'active'    => true
                ],
            ]
        ]);
    }
    public function jenisSarana()
    {
        return $this->renderView('jenis_sarana/index', [
            'page_title'        => 'Jenis Sarana',
            'page_header_title' => 'Jenis Sarana',
            'pages_path'        => [
                'master' => [
                    'url'       => route_to('master'),
                    'active'    => false
                ],
                'jenis sarana' => [
                    'url'       => '',
                    'active'    => true
                ],
            ]
        ]);
    }
    public function merkSarana()
    {
        return $this->renderView('merk_sarana/index', [
            'page_title'        => 'Merk Sarana',
            'page_header_title' => 'Merk Sarana',
            'pages_path'        => [
                'master' => [
                    'url'       => route_to('master'),
                    'active'    => false
                ],
                'merk sarana' => [
                    'url'       => '',
                    'active'    => true
                ],
            ]
        ]);
    }
}
