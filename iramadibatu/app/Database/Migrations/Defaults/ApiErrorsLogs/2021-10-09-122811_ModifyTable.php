<?php

namespace App\Database\Migrations\Defaults\ApiErrorsLogs;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('api_errors_logs', 'created_at');
        $this->forge->dropColumn('api_errors_logs', 'updated_at');
        $this->forge->dropColumn('api_errors_logs', 'deleted_at');

        $this->forge->addColumn('api_errors_logs', [
            'sys_issued_user' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'req_is_ajax'
            ],
            'issued_at' => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'req_is_ajax',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->addColumn('api_errors_logs', [
            'created_at' => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'req_is_ajax',
            ],
            'updated_at' => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'req_is_ajax',
            ],
            'deleted_at' => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'req_is_ajax',
            ],
        ]);

        $this->forge->dropColumn('api_errors_logs', 'sys_issued_user');
        $this->forge->dropColumn('api_errors_logs', 'issued_at');
    }
}
