<?php

namespace App\Modules\APIs\BeritaAcara\Models;

use App\Core\CoreApiModel;
use CodeIgniter\I18n\Time;

class BeritaAcaraModel extends CoreApiModel
{
    
    public function __construct()
    {
        parent::__construct('berita_acara');
    }
    
    /**
     * get datatable for pinjam sarana
     * 
     * @param array $dtParams
     * @param bool $history
     * 
     * @return array
     */
    public function customDatatables(array $dtParams, bool $history = false) : array
    {
        $i = 0;

        $this->defaultBuilder()->select(
            '
            berita_acara.*,

            pihak_1.nama as pihak_1_nama,
            pihak_1.nip as pihak_1_nip,
            pihak_2.nama as pihak_2_nama,
            pihak_2.nip as pihak_2_nip,
            '
        );

        $this->defaultBuilder()->join('penanggung_jawab as pihak_1', 'berita_acara.id_pihak_1 = pihak_1.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_2', 'berita_acara.id_pihak_2 = pihak_2.id', 'left');

        foreach($this->columnSearch as $column) {
            if (isset($dtParams['search'])) {
                if ($i === 0) {
                    $this->defaultBuilder()->groupStart();
                    $this->defaultBuilder()->like($column, $dtParams['search']['value']);
                } else {
                    $this->defaultBuilder()->orLike($column, $dtParams['search']['value']);
                }

                if (count($this->columnSearch) - 1 === $i)
                    $this->defaultBuilder()->groupEnd();
            }
            $i++;
        }    

        if (isset($dtParams['order']))
            $this->defaultBuilder()->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);

        if (isset($dtParams['length']) && $dtParams['length'] !== -1)
            $this->defaultBuilder()->limit($dtParams['length'], $dtParams['start']);

        if (!$history)
            $this->defaultBuilder()->where('berita_acara.deleted_at', null);
        else
            $this->defaultBuilder()->where('berita_acara.deleted_at is not null');

        $result = $this->defaultBuilder()->get();
        return $result->getResultArray();
    }

    /**
     * count datatable total data
     * 
     * @param array $dtParams
     * @param string $type
     * @param bool $history
     * 
     * @return array
     */
    public function customCountTotalDatatable(array $dtParams, bool $history = false)
    {
        $i = 0;
        foreach($this->columnSearch as $column) {
            if (isset($dtParams['search']) && !empty($dtParams['search'])) {
                if ($i === 0) {
                    $this->defaultBuilder()->groupStart();
                    $this->defaultBuilder()->like($column, $dtParams['search']['value']);
                } else {
                    $this->defaultBuilder()->orLike($column, $dtParams['search']['value']);
                }

                if (count($this->columnSearch) - 1 === $i)
                    $this->defaultBuilder()->groupEnd();
            }
            $i++;
        }

        if (isset($dtParams['order']))
            $this->defaultBuilder()->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);

        if (!$history)
            $this->defaultBuilder()->where('berita_acara.deleted_at', null);
        else
            $this->defaultBuilder()->where('berita_acara.deleted_at is not null');
    

        return $this->defaultBuilder()
                    ->countAllResults();
    }

    /**
     * count datatable filtered data
     * 
     * @param array $dtParams
     * @param string $type
     * @param bool $history
     * 
     * @return array
     */
    public function customCountTotalFilteredDatatable(bool $history = false) : int
    {
        if (!$history)
            $this->defaultBuilder()->where('deleted_at', null);
        else
            $this->defaultBuilder()->where('deleted_at is not null');
        
        return $this->defaultBuilder()->countAllResults();
    }

    /**
     * create media data
     */
    public function createMediaData(array $data, bool $getId = false)
    {
        $now = Time::now();
        $data['created_at']         = $now->toDateTimeString();
        $data['sys_created_user']   = $this->authenticatedUser;
        $data['updated_at']         = $now->toDateTimeString();
        $data['sys_updated_user']   = $this->authenticatedUser;
        
        $result = $this->builder('media')
                        ->insert($data);
        return $getId ? $this->db->insertID() : $result;
    }
}
