<?php

namespace App\Models;

use App\Core\MyModel;

class BeritaAcaraModel extends MyModel
{
    protected $table                = 'berita_acara';
    protected $returnType           = 'App\Entities\BeritaAcaraEntity';
    protected $allowedFields        = [
        'nama', 
        'nomor', 
        'tanggal', 
        'file_full_path', 
        'file_extension', 
        'file_size', 
        'keterangan',
    ];

    protected $beforeInsert         = [];

    // Datatables
    protected $columnOrder          = ['nama', 'nomor', 'tanggal'];
    protected $columnSearch         = ['nama', 'nomor', 'tanggal'];
}
