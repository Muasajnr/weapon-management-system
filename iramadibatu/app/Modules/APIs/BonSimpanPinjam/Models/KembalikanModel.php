<?php

namespace App\Modules\APIs\BonSimpanPinjam\Models;

use App\Core\CoreApiModel;

class KembalikanModel extends CoreApiModel
{
    protected $columnSearch = ['no_berita_acara', 'pihak_1', 'pihak_2'];
    protected $columnOrder = [];
    
    public function __construct()
    {
        parent::__construct('kembalikan_sarana');
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
            kembalikan_sarana.id as kembalikan_sarana_id,
            sum(kembalikan_sarana.jumlah) as kembalikan_sarana_jumlah,
            kembalikan_sarana.created_at as kembalikan_sarana_tanggal,

            sarana_keamanan.nomor_sarana as nomor_sarana,
            jenis_sarana.name as nama_sarana,
            merk_sarana.name as merk_sarana,

            berita_acara.nomor as berita_acara_nomor,

            pihak_1.nama as pihak_1_nama,
            pihak_1.nip as pihak_1_nip,
            pihak_2.nama as pihak_2_nama,
            pihak_2.nip as pihak_2_nip,

            pinjam_sarana.kode_peminjaman as kode,
            '
        );

        $this->defaultBuilder()->join('pinjam_sarana', 'kembalikan_sarana.id_pinjam_sarana = pinjam_sarana.id', 'left');
        $this->defaultBuilder()->join('berita_acara', 'kembalikan_sarana.id_berita_acara = berita_acara.id', 'left');
        $this->defaultBuilder()->join('sarana_keamanan', 'pinjam_sarana.id_sarana_keamanan = sarana_keamanan.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_1', 'berita_acara.id_pihak_1 = pihak_1.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_2', 'berita_acara.id_pihak_2 = pihak_2.id', 'left');

        foreach($this->columnSearch as $column) {
            if (isset($dtParams['search'])) {
                if ($i === 0) {
                    $this->defaultBuilder()->groupStart();
                    $this->defaultBuilder()->like('berita_acara.nomor', $dtParams['search']['value']);
                } else {
                    if ($column === 'pihak_1') {
                        $this->defaultBuilder()->orLike('pihak_1.nama', $dtParams['search']['value']);
                    } else if ($column === 'pihak_2') {
                        $this->defaultBuilder()->orLike('pihak_2.nama', $dtParams['search']['value']);
                    } else {
                        $this->defaultBuilder()->orLike('kembalikan_sarana.'.$column, $dtParams['search']['value']);
                    }
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
            $this->defaultBuilder()->where('kembalikan_sarana.deleted_at', null);
        else
            $this->defaultBuilder()->where('kembalikan_sarana.deleted_at is not null');

        $this->defaultBuilder()->groupBy('kembalikan_sarana.id_berita_acara');

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

        $this->defaultBuilder()->join('berita_acara', 'kembalikan_sarana.id_berita_acara = berita_acara.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_1', 'berita_acara.id_pihak_1 = pihak_1.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_2', 'berita_acara.id_pihak_2 = pihak_2.id', 'left');

        foreach($this->columnSearch as $column) {
            if (isset($dtParams['search']) && !empty($dtParams['search'])) {
                if ($i === 0) {
                    $this->defaultBuilder()->groupStart();
                    $this->defaultBuilder()->like('berita_acara.nomor', $dtParams['search']['value']);
                } else {
                    if ($column === 'pihak_1') {
                        $this->defaultBuilder()->orLike('pihak_1.nama', $dtParams['search']['value']);
                    } else if ($column === 'pihak_2') {
                        $this->defaultBuilder()->orLike('pihak_2.nama', $dtParams['search']['value']);
                    } else {
                        $this->defaultBuilder()->orLike('kembalikan_sarana.'.$column, $dtParams['search']['value']);
                    }
                }

                if (count($this->columnSearch) - 1 === $i)
                    $this->defaultBuilder()->groupEnd();
            }
            $i++;
        }

        if (isset($dtParams['order']))
            $this->defaultBuilder()->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);

        if (!$history)
            $this->defaultBuilder()->where('kembalikan_sarana.deleted_at', null);
        else
            $this->defaultBuilder()->where('kembalikan_sarana.deleted_at is not null');
    

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
}
