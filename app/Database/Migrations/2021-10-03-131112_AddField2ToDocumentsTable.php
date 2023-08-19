<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddField2ToDocumentsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('documents', [
            'uploaded_media_ext'   => [
                'type' => 'varchar', 
                'constraint' => 20, 
                'null' => false,
                'after' => 'uploaded_media_name',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('documents', 'uploaded_media_ext');
    }
}
