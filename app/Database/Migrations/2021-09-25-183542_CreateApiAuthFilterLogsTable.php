<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApiAuthFilterLogsTable extends Migration
{

    private $tableName = 'api_auth_filter_logs';

    public function up(): void
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'username'          => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'access_token'      => ['type' => 'varchar', 'constraint' => 500, 'null' => false],
            'access_token_key'  => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);
        
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
