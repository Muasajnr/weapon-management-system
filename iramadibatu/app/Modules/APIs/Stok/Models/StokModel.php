<?php

namespace App\Modules\APIs\Stok\Models;

use App\Core\CoreApiModel;

class StokModel extends CoreApiModel
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
     * @param bool $history
     * 
     * @return array
     */
    public function customDatatable(array $dtParams, bool $history = false) : array
    {
        $i = 0;

        $statusStok = 'IF(count(sarana_keamanan.id_jenis_sarana)<10, "sedikit", IF(count(sarana_keamanan.id_jenis_sarana)<50, "lumayan", IF(count(sarana_keamanan.id_jenis_sarana)<100, "banyak", "unknown")))';
        $this->defaultBuilder()->select(
            "
            jenis_sarana.id as id_nama_sarana,
            jenis_sarana.name as nama_sarana,
            ifnull(sum(pinjam_sarana.jumlah),0) as sedang_dipinjam,
            ifnull(sum(distribusi_sarana.jumlah),0) as sudah_didistribusi,
            (ifnull(sum(sarana_keamanan.jumlah),0)-ifnull(sum(pinjam_sarana.jumlah),0)-ifnull(sum(distribusi_sarana.jumlah),0)) as stok,
            $statusStok as status_stok
            "
        );
        
        $this->defaultBuilder()->join('jenis_sarana', 'jenis_sarana.id = sarana_keamanan.id_jenis_sarana', 'left');
        $this->defaultBuilder()->join('pinjam_sarana', 'pinjam_sarana.id_sarana_keamanan = sarana_keamanan.id', 'left');
        $this->defaultBuilder()->join('distribusi_sarana', 'distribusi_sarana.id_sarana_keamanan = sarana_keamanan.id', 'left');
        
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

        if (!$history) {
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);
        } else {
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at is not null');
        }

        $this->defaultBuilder()->groupBy('sarana_keamanan.id_jenis_sarana');


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
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);
        else
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at is not null');

        $this->defaultBuilder()->groupBy('sarana_keamanan.id_jenis_sarana');

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

        $this->defaultBuilder()->groupBy('sarana_keamanan.id_jenis_sarana');
        
        return $this->defaultBuilder()->countAllResults();
    }
}
