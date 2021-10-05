<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSaranaKeamananTable extends Migration
{
    private $tableName = 'sarana_keamanan';

    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $fields = [
            'id_berita_acara'   => ['type' => 'int', 'constraint' => 9, 'null' => false],
            'tipe'              => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'nama'              => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'merk'              => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'satuan'            => ['type' => 'varchar', 'constraint' => 30, 'default' => 'unit', 'null' => true],
            'jumlah'            => ['type' => 'int', 'constraint' => 9, 'default' => 1, 'null' => true],
            'nomor_sarana'      => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'nomor_bpsa'        => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'kondisi'           => ['type' => 'enum("baik", "rusak")', 'default' => 'baik', 'null' => true],
            'keterangan'        => ['type' => 'text', 'null' => true],
            'qrcode_secret'     => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
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

        $this->forge->addForeignKey('id_berita_acara', 'berita_acara', 'id');

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
