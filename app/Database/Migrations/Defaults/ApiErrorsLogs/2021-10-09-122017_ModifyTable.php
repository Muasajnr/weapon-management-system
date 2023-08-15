<?php

namespace App\Database\Migrations\Defaults\ApiErrorsLogs;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('api_errors_logs', [
            'req_path' => [
                'type'  => 'varchar',
                'constraint'    => 255,
                'null'  => true,
                'after' => 'trace'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('api_errors_logs', 'req_path');
    }
}
