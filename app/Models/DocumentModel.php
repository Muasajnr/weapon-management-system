<?php

namespace App\Models;

use App\Core\MyModel;

class DocumentModel extends MyModel
{
    protected $table                = 'documents';
    protected $returnType           = 'App\Entities\DocumentEntity';
    protected $allowedFields        = ['doc_name', 'doc_number', 'doc_date', 'doc_image', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [null, null, 'doc_name', 'doc_number', 'doc_date'];
    protected $columnSearch         = ['doc_name', 'doc_number', 'doc_date'];

    public function __construct()
    {
        parent::__construct();
    }
}
