<?php

namespace App\Database\Migrations\Defaults\BeritaAcara;

use CodeIgniter\Database\Migration;

class ModifyBeritaAcaraTable2 extends Migration
{
    public function up()
    {
        $this->forge->addColumn('berita_acara', [
            'id_media'  => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
                'after' => 'id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('berita_acara', 'id_media');
    }
}
