<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{

    private $tableName = 'users';

    public function up(): void
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'fullname'      => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'username'      => ['type' => 'varchar', 'constraint' => 20, 'null' => false],
            'email'         => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'password'      => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'level'         => ['type' => 'enum("admin", "user", "unknown")', 'default' => 'unknown', 'null' => false],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addUniqueKey('fullname');
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        
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
