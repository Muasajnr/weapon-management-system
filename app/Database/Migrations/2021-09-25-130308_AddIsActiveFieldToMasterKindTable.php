<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsActiveFieldToMasterKindTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('inventory_types', [
            'is_active' => [
                'type'  => 'tinyint',
                'default'   => 0,
                'after' => 'desc',
            ],
        ]);
        $this->forge->addColumn('firearms_types', [
            'is_active' => [
                'type'  => 'tinyint',
                'default'   => 0,
                'after' => 'desc',
            ],
        ]);
        $this->forge->addColumn('firearms_brands', [
            'is_active' => [
                'type'  => 'tinyint',
                'default'   => 0,
                'after' => 'desc',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('inventory_types', 'is_active');
        $this->forge->dropColumn('firearms_types', 'is_active');
        $this->forge->dropColumn('firearms_brands', 'is_active');
    }
}
