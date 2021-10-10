<?php

namespace App\Models;

use App\Core\MyModel;

class DocumentModel extends MyModel
{
    protected $table                = 'documents';
    protected $returnType           = 'App\Entities\DocumentEntity';
    protected $allowedFields        = ['doc_name', 'doc_number', 'doc_date', 'doc_media', 'uploaded_media_name', 'uploaded_media_ext', 'doc_type', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [null, null, 'doc_name', 'doc_number', 'doc_date', 'doc_type'];
    protected $columnSearch         = ['doc_name', 'doc_number', 'doc_date'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getDocumentEditData($id) : object
    {
        $this->builder()->select(
            '
            doc_name,
            doc_number,
            doc_date,
            doc_media,
            doc_type,
            uploaded_media_name,
            uploaded_media_ext
            '
        );
        $this->builder()->where('id', $id);
        return $this->get()->getRow();
    }
}
