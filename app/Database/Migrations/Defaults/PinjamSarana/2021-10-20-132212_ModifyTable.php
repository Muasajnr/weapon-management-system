<?php

namespace App\Database\Migrations\Defaults\PinjamSarana;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
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
