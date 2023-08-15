<?php

namespace App\Modules\APIs\Dashboard\Models;

use App\Core\CoreApiModel;

class DefaultModel extends CoreApiModel
{
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }
    
    public function stokByJenisInventaris()
    {
        return $this->builder('sarana_keamanan')
            ->select(
                '
                    jenis_inventaris.name as jenis_inventaris,
                    sum(sarana_keamanan.jumlah) as jumlah
                '
            )
            ->join('jenis_inventaris', 'sarana_keamanan.id_jenis_inventaris = jenis_inventaris.id', 'left')
            ->groupBy('sarana_keamanan.id_jenis_inventaris')
            ->get()
            ->getResultArray();
    }

    public function totalStok()
    {
        return $this->builder('sarana_keamanan')
            ->select('sum(jumlah) as jumlah')
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();
    }

    public function totalDipinjam()
    {
        return $this->builder('pinjam_sarana')
            ->select('sum(jumlah) as jumlah')
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();
    }

    public function totalDidistribusi()
    {
        return $this->builder('distribusi_sarana')
            ->select('sum(jumlah) as jumlah')
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();
    }

    public function totalUsers()
    {
        return $this->builder('users')
            ->selectCount('id', 'jumlah')
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();
    }

    public function listDipinjam()
    {
        return $this->builder('pinjam_sarana')
            ->select(
                '
                    jenis_sarana.name as jenis_sarana,
                    sum(pinjam_sarana.jumlah) as jumlah
                '
            )
            ->join('sarana_keamanan', 'sarana_keamanan.id = pinjam_sarana.id_sarana_keamanan', 'left')
            ->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left')
            ->where('pinjam_sarana.deleted_at', null)
            ->where('jenis_sarana.deleted_at', null)
            ->groupBy('pinjam_sarana.id_sarana_keamanan')
            ->get()
            ->getResultArray();
    }

    public function listStok()
    {
        return $this->builder('sarana_keamanan')
            ->select(
                '
                    jenis_sarana.name as jenis_sarana,
                    sum(sarana_keamanan.jumlah) as jumlah
                '
            )
            ->join('jenis_sarana', 'sarana_keamanan.id_jenis_sarana = jenis_sarana.id', 'left')
            ->where('sarana_keamanan.deleted_at', null)
            ->where('jenis_sarana.deleted_at', null)
            ->groupBy('sarana_keamanan.id_jenis_sarana')
            ->get()
            ->getResultArray();
    }
}
