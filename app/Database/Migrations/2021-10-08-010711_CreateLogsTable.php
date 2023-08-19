<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogsTable extends Migration
{

    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addField('id');

        $this->forge->addField([
            'message'       => ['type' => 'varchar', 'constraint' => 500, 'null' => true],
            'code'          => ['type' => 'int', 'constraint' => 9, 'null' => true],
            'file'          => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'line'          => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'trace'         => ['type' => 'text', 'null' => true],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->createTable('api_errors_logs', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable('api_errors_logs');

        $this->db->enableForeignKeyChecks();
    }
}
