<?php

namespace App\Modules\Web\Dashboard\Stok\Controllers;

use App\Core\WebController;

class DefaultController extends WebController
{

    protected $contentIncludes = [
        'datatable',
    ];

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

    public function show($idJenisSarana)
    {
        $params = $this->request->getGet();
        return $this->renderView('show', [
            'page_title'    => 'Detail stok',
            'id_jenis_sarana'   => $idJenisSarana,
            'params'    => $params,
        ]);
    }
}
