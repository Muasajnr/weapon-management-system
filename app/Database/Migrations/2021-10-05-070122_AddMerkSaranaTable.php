<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMerkSaranaTable extends Migration
{
    private $tableName = 'merk_sarana';

    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'name'          => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'desc'          => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            //--- common fields
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'sys_created_user'  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'sys_updated_user'  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'sys_deleted_user'  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'sys_purged_user'   => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
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
