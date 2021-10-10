<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentsTable extends Migration
{
    private $tableName = 'documents';

    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'doc_name'              => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'doc_number'            => ['type' => 'varchar', 'constraint' => 50, 'null' => false],
            'doc_date'              => ['type' => 'date', 'null' => false],
            'doc_media'             => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'doc_type'              => ['type' => 'enum("borrowing", "returning")', 'default' => 'borrowing', 'null' => false],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addUniqueKey('doc_number');

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
