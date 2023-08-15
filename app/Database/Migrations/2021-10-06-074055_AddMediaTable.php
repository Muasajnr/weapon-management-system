<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMediaTable extends Migration
{
    private $tableName = 'media';

    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'file_full_path'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'file_origin_name'      => ['type' => 'varchar', 'constraint' => 500, 'null' => true],
            'file_extension'        => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'file_size'             => ['type' => 'bigint', 'null' => true],
            'file_mime_type'        => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            //--- common fields
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'sys_created_user'  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'sys_updated_user'  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
            'sys_deleted_user'  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'restored_at'       => ['type' => 'datetime', 'null' => true],
            'sys_restored_at'   => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
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
