<?php

namespace App\Models;

use App\Core\MyModel;

class FirearmTypeModel extends MyModel
{
    protected $table                = 'firearms_types';
    protected $returnType           = 'App\Entities\FirearmTypeEntity';
    protected $allowedFields        = ['name', 'desc', 'is_active', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [null, null, 'name', 'desc', 'is_active', 'created_at', null];
    protected $columnSearch         = ['name'];


    public function __construct()
    {
        parent::__construct();
    }
}
