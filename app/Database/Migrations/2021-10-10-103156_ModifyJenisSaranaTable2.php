<?php

namespace App\Database\Migrations\JenisSarana;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('jenis_sarana', [
            'is_active' => [
                'type'  => 'tinyint',
                'constraint'    => 1,
                'default'   => 1,
                'null'  => true,
                'after' => 'name'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('jenis_sarana', 'is_active');
    }
}
