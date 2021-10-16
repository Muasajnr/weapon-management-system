<?php

namespace App\Modules\APIs\BeritaAcara\Models;

use App\Core\CoreApiModel;

class PenanggungJawabModel extends CoreApiModel
{
    protected $columnOrder          = ['nama', 'nip', 'pangkat_golongan', 'jabatan', 'created_at'];
    protected $columnSearch         = ['nama', 'nip', 'pangkat_golongan', 'jabatan', 'created_at'];
    
    public function __construct()
    {
        parent::__construct('penanggung_jawab');
    }
    
}
