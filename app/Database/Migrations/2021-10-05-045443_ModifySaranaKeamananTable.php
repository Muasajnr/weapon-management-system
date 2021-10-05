<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySaranaKeamananTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sarana_keamanan', [
            'id_jenis_inventaris'   => [
                'type' => 'int', 
                'constraint' => 9, 
                'null' => true,
                'after' => 'id',
            ]
        ]);
        $this->forge->addColumn('sarana_keamanan', [
            'id_jenis_sarana'   => [
                'type' => 'int', 
                'constraint' => 9, 
                'null' => true,
                'after' => 'id_jenis_inventaris',
            ]
        ]);
        $this->forge->addColumn('sarana_keamanan', [
            'id_merk_sarana'   => [
                'type' => 'int', 
                'constraint' => 9, 
                'null' => true,
                'after' => 'id_jenis_sarana',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sarana_keamanan', 'id_jenis_inventaris');
        $this->forge->dropColumn('sarana_keamanan', 'id_jenis_sarana');
        $this->forge->dropColumn('sarana_keamanan', 'id_merk_sarana');
    }
}
