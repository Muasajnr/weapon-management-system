<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFirearmsTable extends Migration
{
    
    private $tableName = 'firearms';

    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'inventory_type_id' => ['type' => 'int', 'constraint' => 9, 'null' => false],
            'firearms_type_id'  => ['type' => 'int', 'constraint' => 9, 'null' => false],
            'firearms_brand_id' => ['type' => 'int', 'constraint' => 9, 'null' => false],
            'firearms_number'   => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'bpsa_number'       => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'condition'         => ['type' => 'enum("normal", "damaged")', 'default' => 'normal', 'null' => false],
            'description'       => ['type' => 'text', 'null' => true],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField('id');
        $this->forge->addField($fields);

        $this->forge->addUniqueKey('firearms_number');
        $this->forge->addUniqueKey('bpsa_number');

        $this->forge->addForeignKey('inventory_type_id', 'inventory_types', 'id');
        $this->forge->addForeignKey('firearms_type_id', 'firearms_types', 'id');
        $this->forge->addForeignKey('firearms_brand_id', 'firearms_brands', 'id');

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
