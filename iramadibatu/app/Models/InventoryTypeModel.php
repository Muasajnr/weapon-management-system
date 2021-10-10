<?php

namespace App\Models;

use App\Core\MyModel;
use CodeIgniter\I18n\Time;

class InventoryTypeModel extends MyModel
{
    protected $table                = 'inventory_types';
    protected $returnType           = 'App\Entities\InventoryTypeEntity';
    protected $allowedFields        = ['name', 'desc', 'is_active', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [null, null, 'name', 'desc', 'is_active', 'created_at', null];
    protected $columnSearch         = ['name'];


    public function __construct()
    {
        parent::__construct();
    }
}
