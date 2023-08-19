<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropUniqueKeyFullnameFromUsersTable extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE users DROP INDEX fullname');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE users ADD UNIQUE fullname');
    }
}
