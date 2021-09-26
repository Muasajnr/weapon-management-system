<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowingModel extends Model
{
    protected $table                = 'borrowings';
    protected $returnType           = 'App\Entities\BorrowingEntity';
    protected $allowedFields        = ['firearm_id', 'document_id', 'desc', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [];
    protected $columnSearch         = [];


    public function __construct()
    {
        parent::__construct();
    }
}
