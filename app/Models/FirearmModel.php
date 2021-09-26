<?php

namespace App\Models;

use App\Core\MyModel;

class FirearmModel extends MyModel
{

    protected $table                = 'firearms';
    protected $returnType           = 'App\Entities\FirearmEntity';
    protected $allowedFields        = [
        'inventory_type_id', 
        'firearms_type_id', 
        'firearms_brand_id', 
        'firearms_number', 
        'bpsa_number', 
        'condition', 
        'description', 
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    // Datatables
    protected $columnOrder          = [];
    protected $columnSearch         = [];


    public function __construct()
    {
        parent::__construct();
    }

}
