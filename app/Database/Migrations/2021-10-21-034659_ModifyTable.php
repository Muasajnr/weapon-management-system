<?php

namespace App\Database\Migrations\KembalikanSarana;

use CodeIgniter\Database\Migration;

class ModifyKembalikanSaranaTable extends Migration
{
    public function up()
    {
        // $this->db->query('ALTER TABLE kembalikan_sarana DROP KEY `kembalikan_sarana_id_sarana_keamanan_foreign`');
        // $this->db->query('ALTER TABLE kembalikan_sarana DROP FOREIGN KEY `id_sarana_keamanan`');
        // $this->forge->dropForeignKey('kembalikan_sarana', 'id_sarana_keamanan');
        // $this->forge->modifyColumn('kembalikan_sarana', [
        //     'id_sarana_keamanan'    => [
        //         'name'  => 'id_pinjam_sarana'
        //     ]
        // ]);
        // $this->db->query('ALTER TABLE kembalikan_sarana ADD FOREIGN KEY (id_pinjam_sarana) REFERENCES pinjam_sarana(id)');
        // $this->forge->dropColumn('kembalikan_sarana', 'id_sarana_keamanan');
    }

    public function down()
    {
        // $this->forge->addColumn('kembalikan_sarana', [
        //     'id_sarana_keamanan'    => [
        //         'type'  => 'int',
        //         'constraint'    => 11,
        //         'null'  => true,
        //     ]
        // ]);
        // $this->db->query('ALTER TABLE kembalikan_sarana DROP FOREIGN KEY id_pinjam_sarana');
        // $this->forge->modifyColumn('kembalikan_sarana', [
        //     'id_pinjam_sarana'    => [
        //         'name'  => 'id_sarana_keamanan'
        //     ]
        // ]);
        // $this->db->query('ALTER TABLE kembalikan_sarana ADD FOREIGN KEY (id_sarana_keamanan) REFERENCES sarana_keamanan(id)');
    }
}
