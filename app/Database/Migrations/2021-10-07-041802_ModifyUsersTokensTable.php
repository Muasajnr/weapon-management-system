<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUsersTokensTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('users_tokens', 'created_at');
        $this->forge->dropColumn('users_tokens', 'deleted_at');
        $this->forge->dropColumn('users_tokens', 'updated_at');
        $this->forge->dropColumn('users_tokens', 'sys_created_user');
        $this->forge->dropColumn('users_tokens', 'sys_updated_user');
        $this->forge->dropColumn('users_tokens', 'sys_deleted_user');
        $this->forge->dropColumn('users_tokens', 'sys_purged_user');
    }

    public function down()
    {
        $this->forge->addColumn('users_tokens', [
            'created_at'    => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'token',
            ],
            'sys_created_user'    => [
                'type'  => 'varchar',
                'constraint'  => 100,
                'null'  => true,
                'after' => 'created_at'
            ],
            'updated_at'    => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'sys_created_user',
            ],
            'sys_updated_user'    => [
                'type'  => 'varchar',
                'constraint'  => 100,
                'null'  => true,
                'after' => 'updated_at'
            ],
            'deleted_at'    => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'sys_updated_user',
            ],
            'sys_deleted_user'    => [
                'type'  => 'varchar',
                'constraint'  => 100,
                'null'  => true,
                'after' => 'deleted_at'
            ],
            'sys_purged_user'    => [
                'type'  => 'varchar',
                'constraint'  => 100,
                'null'  => true,
                'after' => 'sys_deleted_user'
            ],
        ]);
    }
}
