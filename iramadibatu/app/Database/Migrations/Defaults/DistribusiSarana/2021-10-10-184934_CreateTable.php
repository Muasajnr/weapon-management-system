<?php

namespace App\Database\Migrations\Defaults\DistribusiSarana;

use CodeIgniter\Database\Migration;

class CreateTable extends Migration
{
    public function up()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'id_berita_acara'  => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
            ],
            'id_sarana_keamanan'  => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
            ],
            'jumlah'  => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
            ],
            'lokasi' => [
                'type'  => 'varchar',
                'constraint'    => 255,
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

        $this->forge->addForeignKey('id_berita_acara', 'berita_acara', 'id');
        $this->forge->addForeignKey('id_sarana_keamanan', 'sarana_keamanan', 'id');

        $this->forge->createTable('distribusi_sarana');
    }

    public function down()
    {
        $this->forge->dropTable('distribusi_sarana');
    }
}
