<?php

namespace App\Modules\Web\Dashboard\BeritaAcara\Controllers;

use App\Core\WebController;

class DefaultController extends WebController
{

    protected $contentIncludes = [
        'datatable',
        'sweetalert',
        'select2',
        'jquery_validation',

        'moment',
        'tempusdominus',
        'bs-custom-file-input'
    ];

    public function __construct()
    {
        parent::__construct(dirname(__FILE__));
    }
    
    public function index()
    {
        return $this->renderView('index', [
            'page_title'        => 'Berita Acara',
            'page_header_title' => 'Berita Acara',
            'pages_path'        => [
                'berita acara' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
