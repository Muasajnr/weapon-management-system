<?php

namespace App\Modules\Login\Controllers;

use App\Core\WebController;

class IndexController extends WebController
{
    public function index()
    {
        return $this->renderView('login');
    }
}
