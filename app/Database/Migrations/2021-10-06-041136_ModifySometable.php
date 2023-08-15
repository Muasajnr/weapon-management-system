<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySometable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('berita_acara', [
            'restored_at'   => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'deleted_at'
            ]
        ]);
        $this->forge->addColumn('berita_acara', [
            'sys_restored_user'   => [
                'type'  => 'varchar',
                'constraint'    => 50,
                'null'  => true,
                'after' => 'restored_at'
            ]
        ]);
        $this->forge->dropColumn('berita_acara', 'sys_purged_user');
    }

    public function down()
    {
        $this->forge->dropColumn('berita_acara', 'restored_at');
        $this->forge->dropColumn('berita_acara', 'sys_restored_user');
        $this->forge->addColumn('berita_acara', [
            'sys_purged_user'   => [
                'type'  => 'varchar',
                'constraint'    => 50,
                'null'  => true,
                'after' => 'restored_at'
            ]
        ]);
    }
}
