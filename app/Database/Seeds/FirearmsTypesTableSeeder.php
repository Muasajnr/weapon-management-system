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
                'name'          => 'Rifle',
                'desc'          => 'Rifle',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'Sniper Rifle',
                'desc'          => 'Sniper Rifle',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'Granade Launcher',
                'desc'          => 'Granade Launcher',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'Mortir',
                'desc'          => 'Mortir',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'Pistol',
                'desc'          => 'Pistol',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'Shotgun',
                'desc'          => 'Shotgun',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'Submachine Gun',
                'desc'          => 'Submachine Gun',
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
