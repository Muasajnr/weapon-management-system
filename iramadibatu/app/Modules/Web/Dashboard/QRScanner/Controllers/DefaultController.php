<?php

namespace App\Modules\Web\Dashboard\QRScanner\Controllers;

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
            'page_title'        => 'QRCode Scanner',
            'page_header_title' => 'QRCode Scanner',
            'pages_path'        => [
                'qrcode scanner' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
