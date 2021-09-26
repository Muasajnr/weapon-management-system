<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table                = 'documents';
    protected $returnType           = 'App\Entities\DocumentEntity';
    protected $allowedFields        = ['doc_name', 'doc_number', 'doc_date', 'doc_image', 'created_at', 'updated_at'];

    // Datatables
    protected $columnOrder          = [];
    protected $columnSearch         = [];


    public function __construct()
    {
        parent::__construct();
    }
}
