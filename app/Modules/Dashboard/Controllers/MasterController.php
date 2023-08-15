<?php

namespace App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;

class MasterController extends BaseController
{
    public function index()
    {
        return redirect()->to('/dashboard/master/jenis_inventaris');
    }
}
