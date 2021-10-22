<?php

namespace App\Modules\APIs\SaranaKeamanan\Models;

use App\Core\CoreApiModel;
use CodeIgniter\I18n\Time;

class SaranaKeamananModel extends CoreApiModel
{
    
    protected $columnSearch = ['nomor_sarana', 'nomor_bpsa'];
    protected $columnOrder = ['nomor_sarana', 'nomor_bpsa'];

    public function __construct()
    {
        parent::__construct('sarana_keamanan');
    }

    /**
     * get all data
     * 
     * @return array|null
     */
    public function getAllData() : ?array
    {
        $this->defaultBuilder()->select(
            '
            sarana_keamanan.id,
            sarana_keamanan.nomor_bpsa,
            sarana_keamanan.nomor_sarana,
            sarana_keamanan.jumlah,
            sarana_keamanan.created_at,
            jenis_inventaris.name as tipe,
            jenis_sarana.name as nama,
            merk_sarana.name as merk
            '
        );
        $this->defaultBuilder()->join('jenis_inventaris', 'sarana_keamanan.id_jenis_inventaris = jenis_inventaris.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('pinjam_sarana', 'sarana_keamanan.id = pinjam_sarana.id_sarana_keamanan', 'left');

        $this->defaultBuilder()->where('jenis_inventaris.deleted_at', null);
        $this->defaultBuilder()->where('jenis_sarana.deleted_at', null);
        $this->defaultBuilder()->where('merk_sarana.deleted_at', null);
        $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);
        $this->defaultBuilder()->where('sarana_keamanan.id NOT IN (SELECT id_sarana_keamanan FROM pinjam_sarana WHERE deleted_at IS NULL)');

        $this->defaultBuilder()->orderBy('sarana_keamanan.id_jenis_inventaris', 'asc');

        $result = $this->defaultBuilder()->get();
        return $result->getResultArray();
    }

    public function getDetail($id)
    {

        $this->defaultBuilder()->select(
            '
            sarana_keamanan.id,
            jenis_sarana.name as nama,
            merk_sarana.name as merk,
            jenis_inventaris.name as tipe,
            sarana_keamanan.nomor_bpsa,
            sarana_keamanan.nomor_sarana,
            sarana_keamanan.jumlah,
            sarana_keamanan.satuan,
            sarana_keamanan.kondisi,
            sarana_keamanan.keterangan,
            media.file_full_path as media_file_full_path,
            media.file_extension as media_file_extension,
            sarana_keamanan.created_at
            '
        );

        $this->defaultBuilder()->join('jenis_inventaris', 'sarana_keamanan.id_jenis_inventaris = jenis_inventaris.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('media', 'sarana_keamanan.id_media = media.id', 'left');

        $this->defaultBuilder()->where('sarana_keamanan.id', $id);

        return $this->defaultBuilder()->get()->getRowArray();
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

        $this->defaultBuilder()->select(
            '
            jenis_sarana.name as nama,
            merk_sarana.name as merk,

            sarana_keamanan.id,
            sarana_keamanan.nomor_bpsa,
            sarana_keamanan.nomor_sarana,
            sarana_keamanan.jumlah,
            sarana_keamanan.satuan,
            sarana_keamanan.kondisi,
            sarana_keamanan.keterangan,
            sarana_keamanan.created_at,
            sarana_keamanan.qrcode_secret,

            media.file_full_path as media_file_full_path,
            media.file_extension as media_file_extension,
            berita_acara.id as id_berita_acara,
            berita_acara.nama as judul_berita_acara,
            berita_acara.nomor as nomor_berita_acara,
            jenis_sarana.id as id_jenis_sarana,
            jenis_sarana.name as nama_jenis_sarana,
            merk_sarana.id as id_merk_sarana,
            merk_sarana.name as nama_merk_sarana
            '
        );

        $this->defaultBuilder()->join('jenis_inventaris', 'sarana_keamanan.id_jenis_inventaris = jenis_inventaris.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('media', 'sarana_keamanan.id_media = media.id', 'left');
        $this->defaultBuilder()->join('berita_acara', 'berita_acara.id = sarana_keamanan.id_berita_acara', 'left');

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
        
        $this->defaultBuilder()->where('sarana_keamanan.id_jenis_inventaris', $dtParams['id_jenis_inventaris'] > 3 ? 3 : $dtParams['id_jenis_inventaris']);
        $this->defaultBuilder()->where('jenis_sarana.deleted_at', null);
        $this->defaultBuilder()->where('merk_sarana.deleted_at', null);

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
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');

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
        
        $this->defaultBuilder()->where('sarana_keamanan.id_jenis_inventaris', $dtParams['id_jenis_inventaris'] > 3 ? 3 : $dtParams['id_jenis_inventaris']);
        $this->defaultBuilder()->where('jenis_sarana.deleted_at', null);
        $this->defaultBuilder()->where('merk_sarana.deleted_at', null);

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
    public function customCountTotalFilteredDatatable(array $dtParams, bool $history = false) : int
    {
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');

        if (!$history)
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);
        else
            $this->defaultBuilder()->where('sarana_keamanan.deleted_at is not null');

        $this->defaultBuilder()->where('sarana_keamanan.id_jenis_inventaris', $dtParams['id_jenis_inventaris'] > 3 ? 3 : $dtParams['id_jenis_inventaris']);
        $this->defaultBuilder()->where('jenis_sarana.deleted_at', null);
        $this->defaultBuilder()->where('merk_sarana.deleted_at', null);
        
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

    public function getByQR(string $qrsecret)
    {
        $this->defaultBuilder()->select(
            '
            sarana_keamanan.id,
            sarana_keamanan.nomor_bpsa,
            sarana_keamanan.nomor_sarana,
            sarana_keamanan.kondisi,
            sarana_keamanan.keterangan,
            sarana_keamanan.created_at,
            sarana_keamanan.qrcode_secret,
            sarana_keamanan.jumlah,

            media.file_full_path as media_file_full_path,
            media.file_extension as media_file_extension,

            jenis_inventaris.name as jenis_inventaris,
            jenis_sarana.id as id_jenis_sarana,
            jenis_sarana.name as nama_jenis_sarana,
            merk_sarana.id as id_merk_sarana,
            merk_sarana.name as nama_merk_sarana
            '
        );

        $this->defaultBuilder()->join('jenis_inventaris', 'sarana_keamanan.id_jenis_inventaris = jenis_inventaris.id', 'left');
        $this->defaultBuilder()->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left');
        $this->defaultBuilder()->join('merk_sarana', 'sarana_keamanan.id_merk_sarana = merk_sarana.id', 'left');
        $this->defaultBuilder()->join('media', 'sarana_keamanan.id_media = media.id', 'left');

        $this->defaultBuilder()->where('sarana_keamanan.qrcode_secret', $qrsecret);
        $this->defaultBuilder()->where('sarana_keamanan.deleted_at', null);

        return $this->defaultBuilder()->get()->getRowArray();
    }

    private function convertType(string $type) : string {
        return ucwords(join(' ', explode('_', $type)));
    }
}
