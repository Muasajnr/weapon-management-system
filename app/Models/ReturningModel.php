<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturningModel extends Model
{
    protected $table                = 'returnings';
    protected $returnType           = 'App\Entities\ReturningEntity';
    protected $allowedFields        = ['borrowing_id', 'document_id', 'desc', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [];
    protected $columnSearch         = [];


    public function __construct()
    {
        parent::__construct();
    }
}
