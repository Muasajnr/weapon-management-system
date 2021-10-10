<?php

namespace App\Database\Migrations\Defaults\PenanggungJawab;

use CodeIgniter\Database\Migration;

class CreateTable extends Migration
{
    public function up()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'nama'  => [
                'type'  => 'varchar',
                'constraint'    => 500,
                'null'  => true,
            ],
            'nip'  => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
            ],
            'pangkat_golongan'  => [
                'type'  => 'varchar',
                'constraint'    => 50,
                'null'  => true,
            ],
            'jabatan'  => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
            ],
            'created_at'    => [
                'type'  => 'datetime',
                'null'  => true,
            ],
            'sys_created_user' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
            ],
            'updated_at'    => [
                'type'  => 'datetime',
                'null'  => true,
            ],
            'sys_updated_user' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
            ],
            'deleted_at'    => [
                'type'  => 'datetime',
                'null'  => true,
            ],
            'sys_deleted_user' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
            ],
            'restored_at'    => [
                'type'  => 'datetime',
                'null'  => true,
            ],
            'sys_restored_user' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
            ],
        ]);
        $this->forge->createTable('penanggung_jawab');
    }

    public function down()
    {
        $this->forge->dropTable('penanggung_jawab');
    }
}
