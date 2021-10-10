<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropUniqueKeyFromInventoryTypes extends Migration
{
    public function up()
    {
        // $this->forge->dropColumn('inventory_types', 'name');
        // $this->forge->addColumn('inventory_types', [
        //     'name' => ['type' => 'varchar', 'constraint' => 255, 'null' => false, 'after' => 'id'],
        // ]);
    }

    public function down()
    {
        // $this->forge->addColumn('inventory_types', [
        //     'name' => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
        // ]);
    }
}
