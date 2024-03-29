<?php

namespace App\Modules\APIs\BonSimpanPinjam\Models;

use App\Core\CoreApiModel;

class PinjamModel extends CoreApiModel
{
    protected $columnSearch = ['kode', 'no_berita_acara', 'pihak_1', 'pihak_2'];
    protected $columnOrder = [];
    
    public function __construct()
    {
        parent::__construct('pinjam_sarana');
    }

    public function getDetailPeminjaman(string $kode)
    {
        $this->defaultBuilder()->select(
            '
            pinjam_sarana.id as id,
            pinjam_sarana.jumlah as jumlah,
            sarana_keamanan.nomor_sarana as nomor,
            sarana_keamanan.nomor_bpsa as bpsa,
            jenis_sarana.name as nama,
            merk_sarana.name as merk,
            jenis_inventaris.name as tipe,
            berita_acara_media.file_full_path,
            berita_acara_media.file_extension,
            pihak_1.nama as pihak_1_nama,
            pihak_1.nip as pihak_1_nip,
            pihak_2.nama as pihak_2_nama,
            pihak_2.nip as pihak_2_nip,
            berita_acara.nomor as nomor_berita_acara,
            berita_acara.nama as judul_berita_acara
            '
        );

        $this->defaultBuilder()->join('sarana_keamanan', 'pinjam_sarana.id_sarana_keamanan = sarana_keamanan.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('jenis_inventaris', 'sarana_keamanan.id_jenis_inventaris = jenis_inventaris.id', 'left');
        $this->defaultBuilder()->join('berita_acara', 'pinjam_sarana.id_berita_acara = berita_acara.id', 'left');
        $this->defaultBuilder()->join('media as berita_acara_media', 'berita_acara.id_media = berita_acara_media.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_1', 'berita_acara.id_pihak_1 = pihak_1.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_2', 'berita_acara.id_pihak_2 = pihak_2.id', 'left');

        $this->defaultBuilder()->where('jenis_inventaris.deleted_at', null);
        $this->defaultBuilder()->where('jenis_sarana.deleted_at', null);
        $this->defaultBuilder()->where('merk_sarana.deleted_at', null);
        $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);
        $this->defaultBuilder()->where('berita_acara.deleted_at', null);
        $this->defaultBuilder()->where('pinjam_sarana.deleted_at', null);

        $this->defaultBuilder()->where('pinjam_sarana.kode_peminjaman', $kode);

        return $this->defaultBuilder()->get()->getResultArray();
    }

    public function getByKode(string $kode)
    {
        $this->defaultBuilder()->select(
            '
            pinjam_sarana.id as id,
            pinjam_sarana.jumlah as jumlah,
            sarana_keamanan.nomor_sarana as nomor,
            jenis_sarana.name as nama,
            merk_sarana.name as merk,
            jenis_inventaris.name as tipe
            '
        );

        $this->defaultBuilder()->join('sarana_keamanan', 'pinjam_sarana.id_sarana_keamanan = sarana_keamanan.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('jenis_inventaris', 'sarana_keamanan.id_jenis_inventaris = jenis_inventaris.id', 'left');

        $this->defaultBuilder()->where('jenis_inventaris.deleted_at', null);
        $this->defaultBuilder()->where('jenis_sarana.deleted_at', null);
        $this->defaultBuilder()->where('merk_sarana.deleted_at', null);
        $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);
        $this->defaultBuilder()->where('pinjam_sarana.kode_peminjaman', $kode);

        return $this->defaultBuilder()->get()->getResultArray();
    }

    /**
     * get last item
     */
    public function getLastData()
    {
        $this->defaultBuilder()->select('nomor_peminjaman');
        $this->defaultBuilder()->where('deleted_at', null);
        $this->defaultBuilder()->orderBy('id', 'desc');
        $this->defaultBuilder()->limit(1);

        return $this->defaultBuilder()->get()->getRowArray();
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
            max(pinjam_sarana.id) as pinjam_sarana_id,
            sum(pinjam_sarana.jumlah) as pinjam_sarana_jumlah,
            max(pinjam_sarana.created_at) as tanggal_pinjam,
            max(pinjam_sarana.nomor_peminjaman) as nomor_peminjaman,
            pinjam_sarana.kode_peminjaman as kode_peminjaman,

            max(sarana_keamanan.nomor_sarana) as nomor_sarana,
            max(jenis_sarana.name) as nama_sarana,
            max(merk_sarana.name) as merk_sarana,

            max(berita_acara.nomor) as berita_acara_nomor,

            max(pihak_1.nama)    as pihak_1_nama,
            max(pihak_1.nip)     as pihak_1_nip,
            max(pihak_2.nama)    as pihak_2_nama,
            max(pihak_2.nip)     as pihak_2_nip,
            '
        );

        $this->defaultBuilder()->join('berita_acara', 'pinjam_sarana.id_berita_acara = berita_acara.id', 'left');
        $this->defaultBuilder()->join('sarana_keamanan', 'pinjam_sarana.id_sarana_keamanan = sarana_keamanan.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_1', 'berita_acara.id_pihak_1 = pihak_1.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_2', 'berita_acara.id_pihak_2 = pihak_2.id', 'left');

        foreach($this->columnSearch as $column) {
            if (isset($dtParams['search'])) {
                if ($i === 0) {
                    $this->defaultBuilder()->groupStart();
                    $this->defaultBuilder()->like('pinjam_sarana.kode_peminjaman', $dtParams['search']['value']);
                } else {
                    if ($column === 'no_berita_acara') {
                        $this->defaultBuilder()->orLike('berita_acara.nomor', $dtParams['search']['value']);
                    } else if ($column === 'pihak_1') {
                        $this->defaultBuilder()->orLike('pihak_1.nama', $dtParams['search']['value']);
                    } else if ($column === 'pihak_2') {
                        $this->defaultBuilder()->orLike('pihak_2.nama', $dtParams['search']['value']);
                    } else {
                        $this->defaultBuilder()->orLike('pinjam_sarana.'.$column, $dtParams['search']['value']);
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
            $this->defaultBuilder()->where('pinjam_sarana.deleted_at', null);
        else
            $this->defaultBuilder()->where('pinjam_sarana.deleted_at is not null');

        $this->defaultBuilder()->groupBy('pinjam_sarana.kode_peminjaman');

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

        $this->defaultBuilder()->join('berita_acara', 'pinjam_sarana.id_berita_acara = berita_acara.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_1', 'berita_acara.id_pihak_1 = pihak_1.id', 'left');
        $this->defaultBuilder()->join('penanggung_jawab as pihak_2', 'berita_acara.id_pihak_2 = pihak_2.id', 'left');

        foreach($this->columnSearch as $column) {
            if (isset($dtParams['search']) && !empty($dtParams['search'])) {
                if ($i === 0) {
                    $this->defaultBuilder()->groupStart();
                    $this->defaultBuilder()->like('pinjam_sarana.kode_peminjaman', $dtParams['search']['value']);
                } else {
                    if ($column === 'no_berita_acara') {
                        $this->defaultBuilder()->orLike('berita_acara.nomor', $dtParams['search']['value']);
                    } else if ($column === 'pihak_1') {
                        $this->defaultBuilder()->orLike('pihak_1.nama', $dtParams['search']['value']);
                    } else if ($column === 'pihak_2') {
                        $this->defaultBuilder()->orLike('pihak_2.nama', $dtParams['search']['value']);
                    } else {
                        $this->defaultBuilder()->orLike('pinjam_sarana.'.$column, $dtParams['search']['value']);
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
            $this->defaultBuilder()->where('pinjam_sarana.deleted_at', null);
        else
            $this->defaultBuilder()->where('pinjam_sarana.deleted_at is not null');
    

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
