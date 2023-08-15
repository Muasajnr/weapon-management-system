<?php

namespace App\Database\Migrations\Logs\ApiErrorsLogs;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{

    protected $DBGroup = 'logs';

    public function up()
    {
        $this->forge->addColumn('api_errors_logs', [
            'sys_created_at' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'created_at'
            ],
            'sys_updated_at' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'updated_at'
            ],
            'sys_deleted_at' => [
                'type'  => 'varchar',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'deleted_at'
            ],
        ]);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropColumn('api_errors_logs', 'sys_created_at');
        $this->forge->dropColumn('api_errors_logs', 'sys_updated_at');
        $this->forge->dropColumn('api_errors_logs', 'sys_deleted_at');

        $this->db->enableForeignKeyChecks();
    }
}
