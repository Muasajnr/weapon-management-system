<?php

namespace App\Database\Migrations\Defaults\JenisInventaris;

use CodeIgniter\Database\Migration;

class ModifyTable extends Migration
{
    public function up()
    {
        // $this->forge->dropColumn('jenis_inventaris', 'sys_purged_user');
        $this->forge->addColumn('jenis_inventaris', [
            'sys_restored_user'   => [
                'type'  => 'varchar',
                'constraint' => 100,
                'null' => true,
                'after' => 'sys_deleted_user'
            ],
            'restored_at'   => [
                'type'  => 'datetime',
                'null' => true,
                'after' => 'sys_deleted_user'
            ]
        ]);
    }

    public function down()
    {
        // $this->forge->addColumn('jenis_inventaris', [
        //     'sys_purged_user'   => [
        //         'type'  => 'varchar',
        //         'constraint' => 100,
        //         'null' => true,
        //         'after' => 'sys_deleted_at'
        //     ]
        // ]);
        $this->forge->dropColumn('jenis_inventaris', 'sys_restored_user');
        $this->forge->dropColumn('jenis_inventaris', 'restored_at');
    }
}
