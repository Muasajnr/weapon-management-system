<?php

namespace App\Modules\Api\Models;

use App\Core\ApiModel;
use App\Modules\Api\Entities\BeritaAcaraEntity;

class BeritaAcaraModel extends ApiModel
{
    protected $table                = 'berita_acara';
    protected $returnType           = '\App\Modules\Api\Entities\BeritaAcaraEntity';
    protected $allowedFields        = ['nama', 'nomor', 'tanggal', 'file_full_path', 'file_origin_name', 'file_extension', 'file_size', 'keterangan'];

    // Datatables
    protected $columnOrder          = [null, null, 'nama', 'nomor', 'tanggal', 'keterangan', 'created_at', null];
    protected $columnSearch         = ['nama', 'nomor', 'tanggal', 'keterangan', 'created_at'];

    public function createBeritaAcara(array $data)
    {
        $beritaacara = new BeritaAcaraEntity();
        $beritaacara->fill($data);
        $this->insert($beritaacara);

        return $this->db->affectedRows() > 0;
    }
}
