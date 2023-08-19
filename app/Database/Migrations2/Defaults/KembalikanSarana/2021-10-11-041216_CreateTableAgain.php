<?php

namespace App\Database\Migrations\Defaults\KembalikanSarana;

use CodeIgniter\Database\Migration;

class CreateTableAgain extends Migration
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
            'id_pinjam_sarana'  => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
            ],
            'jumlah'  => [
                'type'  => 'int',
                'constraint'    => 9,
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
        $this->forge->addForeignKey('id_pinjam_sarana', 'pinjam_sarana', 'id');

        $this->forge->createTable('kembalikan_sarana');
    }

    public function down()
    {
        $this->forge->dropTable('kembalikan_sarana');
    }
}
