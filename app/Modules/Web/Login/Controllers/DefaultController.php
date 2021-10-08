<?php

namespace App\Modules\Web\Login\Controllers;

use App\Core\WebController;

class DefaultController extends WebController
{

    public function __construct()
    {
        parent::__construct(dirname(__FILE__));
    }
    

    public function login()
    {
        return $this->renderView('login');
    }
}
