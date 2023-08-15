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
            'page_title'        => 'Sedang Dipinjam',
            'page_header_title' => 'Sedang Dipinjam',
            'pages_path'        => [
                'Sedang Dipinjam' => [
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

    public function pinjamDetail()
    {
        $kodePeminjaman = $this->request->getGet('kode_peminjaman');
        return $this->renderView('pinjam/show', [
            'page_title'        => 'Detail Pinjam',
            'page_header_title' => 'Detail Pinjam',
            'pages_path'        => [
                'detail pinjam' => [
                    'url'       => '',
                    'active'    => true
                ]
            ],
            'kodePeminjaman'    => $kodePeminjaman
        ]);
    }
}
