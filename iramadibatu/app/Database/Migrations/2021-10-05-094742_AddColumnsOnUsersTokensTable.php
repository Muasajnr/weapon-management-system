<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsOnUsersTokensTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users_tokens', [
            'sys_created_user'   => [
                'type' => 'varchar', 
                'constraint' => 50, 
                'null' => true,
                'after' => 'created_at',
            ]
        ]);
        $this->forge->addColumn('users_tokens', [
            'sys_updated_user'   => [
                'type' => 'varchar', 
                'constraint' => 50, 
                'null' => true,
                'after' => 'updated_at',
            ]
        ]);
        $this->forge->addColumn('users_tokens', [
            'sys_deleted_user'   => [
                'type' => 'varchar', 
                'constraint' => 50, 
                'null' => true,
                'after' => 'deleted_at',
            ]
        ]);
        $this->forge->addColumn('users_tokens', [
            'sys_purged_user'   => [
                'type' => 'varchar', 
                'constraint' => 50, 
                'null' => true,
                'after' => 'sys_deleted_user',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users_tokens', 'sys_created_user');
        $this->forge->dropColumn('users_tokens', 'sys_updated_user');
        $this->forge->dropColumn('users_tokens', 'sys_deleted_user');
        $this->forge->dropColumn('users_tokens', 'sys_purged_user');
    }
}
