<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\WebController;

class DashboardController extends WebController
{
    public function index()
    {
        return $this->renderView('pages/dashboard/index', [
            'page_title' => 'Dashboard'
        ]);
    }
}
