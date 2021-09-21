<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBorrowingsTable extends Migration
{
    private $tableName = 'borrowings';

    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'firearm_id'   => ['type' => 'int', 'constraint' => 9, 'null' => false],
            'document_id'   => ['type' => 'int', 'constraint' => 9, 'null' => false],
            'desc'          => ['type' => 'text', 'null' => true],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addForeignKey('firearm_id', 'firearms', 'id');
        $this->forge->addForeignKey('document_id', 'documents', 'id');

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
