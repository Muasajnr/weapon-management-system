<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldToDocumentsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('documents', [
            'uploaded_media_name'   => [
                'type' => 'varchar', 
                'constraint' => 500, 
                'null' => false,
                'after' => 'doc_media',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('documents', 'uploaded_media_name');
    }
}
