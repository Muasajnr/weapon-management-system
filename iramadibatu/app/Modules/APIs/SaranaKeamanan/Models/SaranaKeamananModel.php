<?php

namespace App\Modules\APIs\SaranaKeamanan\Models;

use App\Core\CoreApiModel;
use CodeIgniter\I18n\Time;

class SaranaKeamananModel extends CoreApiModel
{
    
    protected $columnSearch = [];
    protected $columnOrder = [];

    public function __construct()
    {
        parent::__construct('sarana_keamanan');
    }
    
    /**
     * get datatables
     * 
     * @param array $dtParams
     * @param string $type
     * @param bool $history
     * 
     * @return array
     */
    public function customDatatable(array $dtParams, int $id, bool $history = false) : array
    {
        $i = 0;

        $this->defaultBuilder()->select(
            '
            sarana_keamanan.id,
            sarana_keamanan.nomor_bpsa,
            sarana_keamanan.nomor_sarana,
            jenis_sarana.name as nama,
            merk_sarana.name as merk,
            sarana_keamanan.kondisi,
            sarana_keamanan.keterangan,
            sarana_keamanan.created_at
            '
        );

        $this->defaultBuilder()->join('jenis_inventaris', 'sarana_keamanan.id_jenis_inventaris = jenis_inventaris.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('media', 'sarana_keamanan.id_media = media.id', 'left');

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
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);
        else
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at is not null');
        
        $this->defaultBuilder()->where('sarana_keamanan.id_jenis_inventaris', $id > 3 ? 3 : $id);

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
    public function customCountTotalDatatable(array $dtParams, int $id, bool $history = false)
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
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);
        else
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at is not null');
        
        $this->defaultBuilder()->where('sarana_keamanan.id_jenis_inventaris', $id > 3 ? 3 : $id);

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
    public function customCountTotalFilteredDatatable(int $id, bool $history = false) : int
    {
        if (!$history)
            $this->defaultBuilder()->where('deleted_at', null);
        else
            $this->defaultBuilder()->where('deleted_at is not null');

        $this->defaultBuilder()->where('sarana_keamanan.id_jenis_inventaris', $id > 3 ? 3 : $id);
        
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

    private function convertType(string $type) : string {
        return ucwords(join(' ', explode('_', $type)));
    }
}