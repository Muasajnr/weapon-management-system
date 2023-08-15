<?php

namespace App\Database\Migrations\Logs\ApiErrorsLogs;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{

    protected $DBGroup = 'logs';

    public function up()
    {
        $this->forge->dropColumn('api_errors_logs', 'created_at');
        $this->forge->dropColumn('api_errors_logs', 'updated_at');
        $this->forge->dropColumn('api_errors_logs', 'deleted_at');

        $this->forge->addColumn('api_errors_logs', [
            'sys_issued_at' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'issued_at'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->addColumn('api_errors_logs', [
            'updated_at' => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'trace',
            ],
            'deleted_at' => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'trace',
            ],
            'created_at' => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'trace',
            ],
        ]);

        $this->forge->dropColumn('api_errors_logs', 'sys_issued_at');
    }
}
