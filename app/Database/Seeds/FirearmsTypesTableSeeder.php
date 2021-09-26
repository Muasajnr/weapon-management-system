<?php

namespace App\Database\Seeds;

use App\Models\FirearmTypeModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class FirearmsTypesTableSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Time::now();

        $data = [
            [
                'name'          => 'Shotgun',
                'desc'          => 'Senjata shotgun',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'Pistol',
                'desc'          => 'Senjata pistol',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
        ];

        foreach($data as $item) {
            $firearmTypeModel = new FirearmTypeModel();
            $firearmTypeModel->insert($item);
        }
    }
}
