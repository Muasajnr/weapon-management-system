<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyJenisInventarisTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('jenis_inventaris', [
            'menu_name' => [
                'type'  => 'varchar',
                'constraint' => 100,
                'null' => true,
                'after' => 'desc'
            ],
            'menu_url' => [
                'type'  => 'varchar',
                'constraint' => 500,
                'null' => true,
                'after' => 'menu_name'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('jenis_inventaris', 'menu_name');
        $this->forge->dropColumn('jenis_inventaris', 'menu_url');
    }
}
