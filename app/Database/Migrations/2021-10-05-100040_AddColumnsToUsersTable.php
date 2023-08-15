<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'last_login'   => [
                'type' => 'datetime',
                'null' => true,
                'after' => 'level',
            ]
        ]);
        $this->forge->addColumn('users', [
            'last_logout'   => [
                'type' => 'datetime',
                'null' => true,
                'after' => 'last_login',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'last_login');
        $this->forge->dropColumn('users', 'last_logout');
    }
}
