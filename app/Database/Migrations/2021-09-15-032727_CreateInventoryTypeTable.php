<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryTypeTable extends Migration
{
    private $tableName = 'inventory_types';

    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'name'          => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'desc'          => ['type' => 'text', 'null' => true],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addUniqueKey('name');

        $this->forge->createTable($tableName);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable($tableName);

        $this->db->enableForeignKeyChecks();
    }
}
