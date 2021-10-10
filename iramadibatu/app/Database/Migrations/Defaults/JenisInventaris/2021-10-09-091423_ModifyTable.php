<?php

namespace App\Database\Migrations\Defaults\JenisInventaris;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
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
