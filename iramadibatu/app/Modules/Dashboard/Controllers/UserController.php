<?php

namespace App\Modules\Dashboard\Controllers;

use App\Core\WebController;

class UserController extends WebController
{
    public function index()
    {
        return $this->renderView('pages/users/index', [
            'page_title'    => 'Iramadibatu - User'
        ]);
    }
}
