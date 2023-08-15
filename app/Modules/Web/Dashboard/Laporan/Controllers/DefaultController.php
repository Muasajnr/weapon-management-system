<?php

namespace App\Modules\Web\Dashboard\Laporan\Controllers;

use App\Core\WebController;

class DefaultController extends WebController
{
    public function __construct()
    {
        parent::__construct(dirname(__FILE__));
    }
    
    public function index()
    {
        return $this->renderView('index', [
            'page_title'        => 'Laporan',
            'page_header_title' => 'Laporan',
            'pages_path'        => [
                'laporan' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
