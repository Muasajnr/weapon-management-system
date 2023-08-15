<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeysToSaranaKeamananTable extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE `sarana_keamanan` ADD FOREIGN KEY (id_jenis_inventaris) REFERENCES jenis_inventaris(id)');
        $this->db->query('ALTER TABLE `sarana_keamanan` ADD FOREIGN KEY (id_jenis_sarana) REFERENCES jenis_sarana(id)');
        $this->db->query('ALTER TABLE `sarana_keamanan` ADD FOREIGN KEY (id_merk_sarana) REFERENCES merk_sarana(id)');
    }

    public function down()
    {
        $this->forge->dropForeignKey('sarana_keamanan','id_jenis_inventaris');
        $this->forge->dropForeignKey('sarana_keamanan','id_jenis_sarana');
        $this->forge->dropForeignKey('sarana_keamanan','id_merk_sarana');
    }
}
