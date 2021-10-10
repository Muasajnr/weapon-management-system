<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AllTableSeeder extends Seeder
{
    public function run()
    {
        $this->call('UsersTableSeeder');
        $this->call('InventoryTypesTableSeeder');
        $this->call('FirearmsTypesTableSeeder');
        $this->call('FirearmsBrandsTableSeeder');
        $this->call('FirearmsTableSeeder');
        $this->call('DocumentsTableSeeder');
        $this->call('BorrowingsTableSeeder');
        $this->call('ReturningsTableSeeder');
    }
}
