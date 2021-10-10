<?php

namespace App\Database\Migrations\Defaults\ApiErrorsLogs;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('api_errors_logs', [
            'req_is_ajax'   => [
                'type'  => 'tinyint',
                'null'  => true,
                'after' => 'trace',
            ],
            'req_body'   => [
                'type'  => 'text',
                'null'  => true,
                'after' => 'trace',
            ],
            'req_ip_addr'   => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'trace',
            ],
            'req_headers'   => [
                'type'  => 'text',
                'null'  => true,
                'after' => 'trace',
            ],
            'req_method'   => [
                'type'  => 'varchar',
                'constraint'    => 50,
                'null'  => true,
                'after' => 'trace',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('api_errors_logs', 'req_is_ajax');
        $this->forge->dropColumn('api_errors_logs', 'req_body');
        $this->forge->dropColumn('api_errors_logs', 'req_ip_addr');
        $this->forge->dropColumn('api_errors_logs', 'req_headers');
        $this->forge->dropColumn('api_errors_logs', 'req_method');
    }
}
