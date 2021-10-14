<?php

namespace App\Modules\Web\Dashboard\BonPinjamSarana\Controllers;

use App\Core\WebController;

class DefaultController extends WebController
{

    protected $contentIncludes = [
        'datatable',
        'sweetalert',
        'select2',
        'jquery_validation'
    ];
    
    public function __construct()
    {
        parent::__construct(dirname(__FILE__));
    }
    
    public function pinjam()
    {
        return $this->renderView('pinjam/index', [
            'page_title'        => 'Jenis Inventaris',
            'page_header_title' => 'Jenis Inventaris',
            'pages_path'        => [
                'dashboard' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
    
    public function kembalikan()
    {
        return $this->renderView('kembalikan/index', [
            'page_title'        => 'Jenis Inventaris',
            'page_header_title' => 'Jenis Inventaris',
            'pages_path'        => [
                'dashboard' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
