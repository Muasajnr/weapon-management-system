<?php

namespace App\Database\Migrations\Defaults\SaranaKeamanan;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sarana_keamanan', [
            'sys_distributed_user' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'sys_restored_user',
            ],
            'distributed_at'   => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'sys_restored_user',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sarana_keamanan', 'sys_distributed_user');
        $this->forge->dropColumn('sarana_keamanan', 'distributed_at');
    }
}
