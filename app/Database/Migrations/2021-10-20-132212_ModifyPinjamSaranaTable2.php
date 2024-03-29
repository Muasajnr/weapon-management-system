<?php

namespace App\Database\Migrations\PinjamSarana;

use CodeIgniter\Database\Migration;

class ModifyPinjamSaranaTable2 extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pinjam_sarana', [
            'kode_peminjaman' => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
                'after' => 'nomor_peminjaman'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pinjam_sarana', 'kode_peminjaman');
    }
}
