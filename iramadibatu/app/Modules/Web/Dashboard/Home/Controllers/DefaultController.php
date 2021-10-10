<?php

namespace App\Modules\Web\Dashboard\Home\Controllers;

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
            'page_title'        => 'Dashboard',
            'page_header_title' => 'Dashboard',
            'pages_path'        => [
                'dashboard' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
