<?php

namespace App\Database\Migrations\Defaults\BeritaAcara;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('berita_acara', [
            'id_pihak_2'    => [
                'type'  => 'int',
                'constraint'   => 9,
                'null'  => true,
                'after' => 'tanggal'
            ],
            'id_pihak_1'    => [
                'type'  => 'int',
                'constraint'   => 9,
                'null'  => true,
                'after' => 'tanggal'
            ]
        ]);
        $this->db->query('ALTER TABLE berita_acara ADD FOREIGN KEY (id_pihak_2) REFERENCES penanggung_jawab(id)');
        $this->db->query('ALTER TABLE berita_acara ADD FOREIGN KEY (id_pihak_1) REFERENCES penanggung_jawab(id)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE berita_acara DROP FOREIGN KEY id_pihak_2');
        $this->db->query('ALTER TABLE berita_acara DROP FOREIGN KEY id_pihak_1');
        $this->forge->dropColumn('berita_acara', 'id_pihak_2');
        $this->forge->dropColumn('berita_acara', 'id_pihak_1');
    }
}
