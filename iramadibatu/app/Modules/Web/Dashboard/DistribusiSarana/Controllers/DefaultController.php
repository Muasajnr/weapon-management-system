<?php

namespace App\Modules\Web\Dashboard\DistribusiSarana\Controllers;

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
            'page_title'        => 'Distribusi Sarana',
            'page_header_title' => 'Distribusi Sarana',
            'pages_path'        => [
                'Data Distribusi Sarana' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
