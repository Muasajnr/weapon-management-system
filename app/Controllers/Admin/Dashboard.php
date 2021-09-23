<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index() {
        return redirect()->to('/dashboard/home');
    }

    public function home()
    {
        return view('dashboard/home/home', [
            'page_title' => 'Home'
        ]);
    }
}
