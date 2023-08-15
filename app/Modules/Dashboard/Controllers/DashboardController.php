<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\WebController;

class DashboardController extends WebController
{
    public function index()
    {
        /**
         * ambil inspirasi dashboard dari idp
         */
        return $this->renderView('pages/dashboard/index', [
            'page_title' => 'Dashboard'
        ]);
    }
}
