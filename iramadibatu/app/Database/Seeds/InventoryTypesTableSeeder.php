<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;
use App\Models\InventoryTypeModel;

class InventoryTypesTableSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Time::now();

        $data = [
            [
                'name'          => 'Senjata Api',
                'desc'          => 'Deskripsi untuk tipe inventaris senjata api',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'Senjata Api Non Organik',
                'desc'          => 'Deskripsi untuk tipe inventaris senjata api non organik',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
        ];

        foreach($data as $item) {
            $inventoryTypeModel = new InventoryTypeModel();
            $inventoryTypeModel->insert($item);
        }
    }
}
