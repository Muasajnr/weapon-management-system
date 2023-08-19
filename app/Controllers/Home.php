<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        var_dump('test');die();
        return redirect()->to('/login');
    }
}
