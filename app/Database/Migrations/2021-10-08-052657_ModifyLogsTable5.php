<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyLogsTable5 extends Migration
{

    public function up()
    {
        $this->forge->addColumn('api_errors_logs', [
            'accessed_url_path' => [
                'type'  => 'varchar',
                'constraint'    => 255,
                'null'  => true,
                'after' => 'id'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('api_errors_logs', 'accessed_url_path');
    }
}
