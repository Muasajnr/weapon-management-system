<?php

namespace App\Database\Migrations\MerkSarana;

use CodeIgniter\Database\Migration;

class ModifyMerekSaranaTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('merk_sarana', 'sys_purged_user');
        $this->forge->addColumn('merk_sarana', [
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
        $this->forge->addColumn('merk_sarana', [
            'sys_purged_user'   => [
                'type'  => 'varchar',
                'constraint' => 100,
                'null' => true,
                'after' => 'sys_deleted_at'
            ]
        ]);
        $this->forge->dropColumn('merk_sarana', 'sys_restored_user');
        $this->forge->dropColumn('merk_sarana', 'restored_at');
    }
}
