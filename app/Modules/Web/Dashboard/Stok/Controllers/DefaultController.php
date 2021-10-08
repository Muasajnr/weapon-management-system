<?php

namespace App\Modules\Web\Dashboard\Stok\Controllers;

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
            'page_title'        => 'Stok Sarana Keamanan',
            'page_header_title' => 'Stok Sarana Keamanan',
            'pages_path'        => [
                'data stok' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
