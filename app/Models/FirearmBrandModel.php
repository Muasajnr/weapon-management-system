<?php

namespace App\Models;

use App\Core\MyModel;

class FirearmBrandModel extends MyModel
{

    protected $table                = 'firearms_brands';
    protected $returnType           = 'App\Entities\FirearmEntity';
    protected $allowedFields        = ['name', 'desc', 'is_active', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [];
    protected $columnSearch         = [];


    public function __construct()
    {
        parent::__construct();
    }

}
