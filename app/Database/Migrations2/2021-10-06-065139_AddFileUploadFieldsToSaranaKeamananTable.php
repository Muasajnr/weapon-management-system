<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFileUploadFieldsToSaranaKeamananTable extends Migration
{
    public function up()
    {
        // $this->forge->addColumn('sarana_keamanan', [
        //     'file_full_path'  => [
        //         'type'  => 'varchar',
        //         'constraint'    => 500,
        //         'null'  => true,
        //         'after' => 'file_full_path',
        //     ],
        // ]);
    }

    public function down()
    {
        //
    }
}
