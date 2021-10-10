<?php

namespace App\Database\Migrations\Defaults\SaranaKeamanan;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('sarana_keamanan', 'sys_purged_user');
        $this->forge->addColumn('sarana_keamanan', [
            'sys_restored_user' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'sys_deleted_user',
            ],
            'restored_at'   => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'sys_deleted_user',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->addColumn('sarana_keamanan', [
            'sys_restored_user' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'sys_deleted_user',
            ],
        ]);
        $this->forge->dropColumn('sarana_keamanan', 'sys_restored_user');
        $this->forge->dropColumn('sarana_keamanan', 'restored_at');
    }
}
