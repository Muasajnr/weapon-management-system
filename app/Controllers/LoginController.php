<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        return view('login/login');
    }

    public function login2()
    {
        return view('login/login2');
    }
}
