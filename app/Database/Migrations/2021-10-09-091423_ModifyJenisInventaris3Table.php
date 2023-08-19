<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyJenisInventaris3Table extends Migration
{
    public function up()
    {
        $this->forge->addColumn('jenis_inventaris', [
            'is_active' => [
                'type'  => 'tinyint',
                'default'   => 0,
                'after' => 'name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('jenis_inventaris', 'is_active');
    }
}
