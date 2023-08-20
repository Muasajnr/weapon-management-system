<?php

namespace App\Database\Migrations\Defaults\PinjamSarana;

use CodeIgniter\Database\Migration;

class ModifyPinjamSaranaTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pinjam_sarana', [
            'nomor_peminjaman' => [
                'type'  => 'char',
                'constraint'    => 7,
                'null'  => true,
                'after' => 'id'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pinjam_sarana', 'nomor_peminjaman');
    }
}
