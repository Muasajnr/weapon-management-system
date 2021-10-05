<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBeritaAcaraTable extends Migration
{
    private $tableName = 'berita_acara';

    public function up()
    {   
        $this->db->disableForeignKeyChecks();

        $fields = [
            'nama'              => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'nomor'             => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'tanggal'           => ['type' => 'date', 'null' => true],
            'file_full_path'    => ['type' => 'varchar', 'constraint' => 150, 'null' => true],
            'file_extension'    => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'file_size'         => ['type' => 'int', 'constraint' => 9, 'null' => true],
            'keterangan'        => ['type' => 'text', 'null' => true],

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
