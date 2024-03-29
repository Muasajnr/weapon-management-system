<?php

namespace App\Database\Migrations\Logs\ApiErrorsLogs;

use CodeIgniter\Database\Migration;

class ModifyTable4 extends Migration
{
    protected $DBGroup = 'logs';

    public function up()
    {
        $this->forge->modifyColumn('api_errors_logs', [
            'sys_issued_at' => [
                'name'  => 'sys_issued_user',
                'type'  => 'varchar',
                'constraint'    => 100,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('api_errors_logs', [
            'sys_issued_user'   => [
                'name'  => 'sys_issued_at',
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
            ],
        ]);
    }
}
