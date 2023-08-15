<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUsersTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('users', 'sys_purged_user');
    }

    public function down()
    {
        $this->forge->addColumn('users', [
            'sys_purged_user'   => [
                'type'  => 'varchar',
                'constraint'    => '100',
                'null'  => true,
                'after' => 'sys_restored_user'
            ],
        ]);
    }
}
