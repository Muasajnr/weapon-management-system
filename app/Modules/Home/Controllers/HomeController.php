<?php

namespace App\Modules\Home\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return redirect()->to('/login');
    }
}
