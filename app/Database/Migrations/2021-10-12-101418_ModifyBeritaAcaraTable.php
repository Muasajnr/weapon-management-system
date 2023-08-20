<?php

namespace App\Database\Migrations\BeritaAcara;

use CodeIgniter\Database\Migration;

class ModifyBeritaAcaraTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('berita_acara', 'file_full_path');
        $this->forge->dropColumn('berita_acara', 'file_origin_name');
        $this->forge->dropColumn('berita_acara', 'file_extension');
        $this->forge->dropColumn('berita_acara', 'file_size');
    }

    public function down()
    {
        $this->forge->addColumn('berita_acara', [
            'file_full_path'    => [
                'type'   => 'varchar',
                'constraint'    => 150,
                'null'  => true,
                'after' => 'keterangan',
            ],
            'file_origin_name'    => [
                'type'   => 'varchar',
                'constraint'    => 500,
                'null'  => true,
                'after' => 'keterangan',
            ],
            'file_extension'    => [
                'type'   => 'varchar',
                'constraint'    => 20,
                'null'  => true,
                'after' => 'keterangan',
            ],
            'file_size'    => [
                'type'   => 'int',
                'constraint'    => 9,
                'null'  => true,
                'after' => 'keterangan',
            ],
        ]);
    }
}
