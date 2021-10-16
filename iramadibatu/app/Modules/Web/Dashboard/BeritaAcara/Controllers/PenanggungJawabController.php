<?php

namespace App\Modules\Web\Dashboard\BeritaAcara\Controllers;

use App\Core\WebController;

class PenanggungJawabController extends WebController
{

    protected $contentIncludes = [
        'datatable',
        'sweetalert',
        'jquery_validation',
    ];

    public function list()
    {
        return $this->renderView('penanggung_jawab/list', [
            'page_title'        => 'Penanggung Jawab',
            'page_header_title' => 'Penanggung Jawab',
            'pages_path'        => [
                'penanggung jawab' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
}
