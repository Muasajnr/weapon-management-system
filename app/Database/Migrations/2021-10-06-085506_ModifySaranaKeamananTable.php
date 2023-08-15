<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySaranaKeamananTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sarana_keamanan', [
            'id_media'  => [
                'type'  => 'int',
                'constraint' => 9,
                'null'  => true,
                'after' => 'id'
            ]
        ]);
        $this->db->query('ALTER TABLE `sarana_keamanan` ADD FOREIGN KEY (id_media) REFERENCES media(id)');
    }

    public function down()
    {
        $this->forge->dropColumn('sarana_keamanan', 'id_media');
        $this->forge->dropForeignKey('sarana_keamanan', 'id_media');
    }
}
