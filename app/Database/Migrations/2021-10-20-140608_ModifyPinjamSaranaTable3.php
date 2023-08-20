<?php

namespace App\Database\Migrations\PinjamSarana;

use CodeIgniter\Database\Migration;

class ModifyPinjamSaranaTable3 extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('pinjam_sarana', [
            'nomor_peminjaman'  => [
                'name' => 'kode_peminjaman',
                'type' => 'char',
                'constraint' => 7,
                'null' => true
            ],
            'kode_peminjaman'  => [
                'name' => 'nomor_peminjaman',
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('pinjam_sarana', [
            'kode_peminjaman'  => [
                'name' => 'nomor_peminjaman',
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true
            ],
            'nomor_peminjaman'  => [
                'name' => 'kode_peminjaman',
                'type' => 'char',
                'constraint' => 7,
                'null' => true
            ]
        ]);
    }
}
