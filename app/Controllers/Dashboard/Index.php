<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Index extends BaseController
{
    public function index() {
        return redirect()->to('/dashboard/home');
    }

    public function home()
    {
        return view('dashboard/home/index', [
            'page_title' => 'Home'
        ]);
    }

    public function master()
    {
        return redirect()->to('/dashboard/master/jenis-inventaris');
    }

    public function inventory_types()
    {
        return view('dashboard/master/inventory_types/index', [
            'page_title' => 'Jenis Inventory'
        ]);
    }

    public function firearms_types()
    {
        return view('dashboard/master/firearms_types/index', [
            'page_title' => 'Jenis Senjata Api'
        ]);
    }

    public function firearms_brand()
    {
        return view('dashboard/master/firearms_brands/index', [
            'page_title' => 'Merk Senjata Api'
        ]);
    }
}
