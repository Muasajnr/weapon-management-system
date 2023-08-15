<?php

namespace App\Controllers\TestCIFeatures;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class OnlyTest extends BaseController
{
    public function index()
    {
        //
    }

    public function testTimeNow()
    {
        print_r(Time::now()->toDateTimeString());die();
    }
}
