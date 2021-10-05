<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class SaranaKeamananController extends BaseController
{
    public function tambah()
    {
        return view('dashboard/sarana_keamanan/tambah', [
            'page_title' => 'Sarana Keamanan - Tambah'
        ]);
    }

    public function senjata_api()
    {
        return view('dashboard/sarana_keamanan/senjata_api', [
            'page_title' => 'Sarana Keamanan - Senjata Api'
        ]);
    }

    public function non_organik()
    {
        return view('dashboard/sarana_keamanan/non_organik', [
            'page_title' => 'Sarana Keamanan - Non Organik'
        ]);
    }

    public function lainnya()
    {
        return view('dashboard/sarana_keamanan/lainnya', [
            'page_title' => 'Sarana Keamanan - Lainnya'
        ]);
    }
}
