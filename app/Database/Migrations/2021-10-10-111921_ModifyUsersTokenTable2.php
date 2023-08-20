<?php

namespace App\Database\Migrations\Defaults\UsersTokens;

use CodeIgniter\Database\Migration;

class ModifyUsersTokenTable2 extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users_tokens', [
            'updated_at'    => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'token'
            ],
            'created_at'    => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'token'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users_tokens', 'updated_at');
        $this->forge->dropColumn('users_tokens', 'deleted_at');
    }
}
