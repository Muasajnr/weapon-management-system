<?php

namespace App\Database\Migrations\Defaults\BeritaAcara;

use CodeIgniter\Database\Migration;

class ModifyBeritaAcaraTable3 extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE berita_acara ADD FOREIGN KEY (id_media) REFERENCES media(id)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE berita_acara DROP FOREIGN KEY id_media;');
    }
}
