<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'restored_at'   => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'sys_deleted_user'
            ],
            'sys_restored_user'   => [
                'type'  => 'varchar',
                'constraint'    => '100',
                'null'  => true,
                'after' => 'restored_at'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'restored_at');
        $this->forge->dropColumn('users', 'sys_restored_user');
    }
}
