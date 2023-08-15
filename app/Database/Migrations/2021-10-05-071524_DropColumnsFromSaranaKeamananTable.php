<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropColumnsFromSaranaKeamananTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('sarana_keamanan', 'tipe');
        $this->forge->dropColumn('sarana_keamanan', 'nama');
        $this->forge->dropColumn('sarana_keamanan', 'merk');
    }

    public function down()
    {
        $this->forge->addColumn('sarana_keamanan', [
            'tipe'   => [
                'type' => 'varchar', 
                'constraint' => 100, 
                'null' => true,
                'after' => 'id',
            ]
        ]);
        $this->forge->addColumn('sarana_keamanan', [
            'nama'   => [
                'type' => 'varchar', 
                'constraint' => 100, 
                'null' => true,
                'after' => 'tipe',
            ]
        ]);
        $this->forge->addColumn('sarana_keamanan', [
            'merk'   => [
                'type' => 'varchar', 
                'constraint' => 100, 
                'null' => true,
                'after' => 'nama',
            ]
        ]);
    }
}
