<?php

namespace App\Modules\Web\Dashboard\SaranaKeamanan\Controllers;

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
    
    public function senjataApi()
    {
        return $this->renderView('senjata_api/index', [
            'page_title'        => 'Senjata Api',
            'page_header_title' => 'Senjata Api',
            'pages_path'        => [
                'dashboard' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
    
    public function nonOrganik()
    {
        return $this->renderView('non_organik/index', [
            'page_title'        => 'Non Organik',
            'page_header_title' => 'Non Organik',
            'pages_path'        => [
                'dashboard' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }
    
    public function lainnya()
    {
        return $this->renderView('lainnya/index', [
            'page_title'        => 'Lainnya',
            'page_header_title' => 'Lainnya',
            'pages_path'        => [
                'dashboard' => [
                    'url'       => '',
                    'active'    => true
                ]
            ]
        ]);
    }

    public function senjataApiShow($id)
    {

        return $this->renderView('senjata_api/show', [
            'page_title'        => 'Detail'
        ]);
    }
}
