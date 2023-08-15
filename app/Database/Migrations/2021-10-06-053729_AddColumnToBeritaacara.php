<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToBeritaacara extends Migration
{
    public function up()
    {
        $this->forge->addColumn('berita_acara', [
            'file_origin_name'  => [
                'type'  => 'varchar',
                'constraint'    => 500,
                'null'  => true,
                'after' => 'file_full_path',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('berita_acara', 'file_origin_name');
    }
}
