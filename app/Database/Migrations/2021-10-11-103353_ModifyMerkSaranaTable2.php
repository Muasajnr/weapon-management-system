<?php

namespace App\Database\Migrations\MerkSarana;

use CodeIgniter\Database\Migration;

class ModifyMerkSaranaTable2 extends Migration
{
    public function up()
    {
        $this->forge->addColumn('merk_sarana', [
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
        $this->forge->dropColumn('merk_sarana', 'is_active');
    }
}
