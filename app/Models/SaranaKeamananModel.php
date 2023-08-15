<?php

namespace App\Models;

use App\Core\MyModel;

class SaranaKeamananModel extends MyModel
{
    protected $table                = 'sarana_keamanan';
    protected $returnType           = 'App\Entities\SaranaKeamananEntity';
    protected $allowedFields        = [
        'id_berita_acara', 
        'tipe', 
        'nama', 
        'merk', 
        'satuan', 
        'jumlah', 
        'nomor_sarana',
        'nomor_bpsa',
        'kondisi',
        'keterangan',
        'qrcode_secret',
    ];

    // Datatables
    protected $columnOrder          = ['tipe', 'nama', 'merk', 'satuan', 'nomor_sarana', 'nomor_bpsa', 'kondisi'];
    protected $columnSearch         = ['tipe', 'nama', 'merk', 'satuan', 'nomor_sarana', 'nomor_bpsa', 'kondisi'];
}
