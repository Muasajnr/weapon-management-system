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

    public function firearms_brands()
    {
        return view('dashboard/master/firearms_brands/index', [
            'page_title' => 'Merk Senjata Api'
        ]);
    }

    public function stocks()
    {
        return view('dashboard/stock/index', [
            'page_title' => 'Data Stok Senjata'
        ]);
    }

    public function firearms()
    {
        return view('dashboard/firearms/index', [
            'page_title' => 'Data Senjata Api'
        ]);
    }

    public function borrowings()
    {
        return view('dashboard/borrowing/index', [
            'page_title' => 'Peminjaman Senjata Api'
        ]);
    }

    public function returnings()
    {
        return view('dashboard/returnings/index', [
            'page_title' => 'Pengembalian Senjata Api'
        ]);
    }

    public function documents()
    {
        return view('dashboard/documents/index', [
            'page_title' => 'Berita Acara'
        ]);
    }

    public function reports()
    {
        return view('dashboard/report/index', [
            'page_title' => 'Laporan'
        ]);
    }

    public function users()
    {
        return view('dashboard/users/index', [
            'page_title' => 'Data User'
        ]);
    }
}
