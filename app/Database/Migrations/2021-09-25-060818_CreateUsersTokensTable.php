<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTokensTable extends Migration
{
    private $tableName = 'users_tokens';

    public function up(): void
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'username'      => ['type' => 'varchar', 'constraint' => 100, 'null' => false,],
            'token'         => ['type' => 'text', 'null' => false,],
            'created_at'    => ['type' => 'datetime', 'null' => true,],
            'updated_at'    => ['type' => 'datetime', 'null' => true,],
            'deleted_at'    => ['type' => 'datetime', 'null' => true,],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('token');
        
        $this->forge->createTable($this->tableName);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable($this->tableName);
        
        $this->db->enableForeignKeyChecks();
    }
}
