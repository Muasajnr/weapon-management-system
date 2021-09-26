<?php

namespace App\Database\Seeds;

use App\Models\FirearmBrandModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class FirearmsBrandsTableSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Time::now();

        $data = [
            [
                'name'          => 'SS2-V5 A1',
                'desc'          => 'SS2-V5 A1',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SS2-V7 SUBSONIC',
                'desc'          => 'SS2-V7 SUBSONIC',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SS3',
                'desc'          => 'SS3',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SS2-V5 KAL. 5.56 MM',
                'desc'          => 'SS2-V5 KAL. 5.56 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SS2-V4 HB KAL. 5.56 MM',
                'desc'          => 'SS2-V4 HB KAL. 5.56 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SPR-4',
                'desc'          => 'SPR-4',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SPR-3 KAL. 7.62 MM',
                'desc'          => 'SPR-3 KAL. 7.62 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SPR-2 KAL. 12.7 MM',
                'desc'          => 'SPR-2 KAL. 12.7 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SM2 V2 KAL. 7.62MM',
                'desc'          => 'SM2 V2 KAL. 7.62MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SM2 V1 KAL.7.62 MM',
                'desc'          => 'SM2 V1 KAL.7.62 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SM-5 KAL. 12.7 MM',
                'desc'          => 'SM-5 KAL. 12.7 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SPG1-V4 CAL. 40 MM',
                'desc'          => 'SPG1-V4 CAL. 40 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SPG1-V3 KAL. 40 MM',
                'desc'          => 'SPG1-V3 KAL. 40 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SPG1-V2 KAL. 40 MM',
                'desc'          => 'SPG1-V2 KAL. 40 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'MO-2 KAL. 60 MM LR',
                'desc'          => 'MO-2 KAL. 60 MM LR',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'MO-3 KAL. 81 MM',
                'desc'          => 'MO-3 KAL. 81 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'G2 PREMIUM KAL. 9MM',
                'desc'          => 'G2 PREMIUM KAL. 9MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'MAG4',
                'desc'          => 'MAG4',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'SG-1 12 GAUGE',
                'desc'          => 'SG-1 12 GAUGE',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'PM3',
                'desc'          => 'PM3',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'PM2-V1 KAL. 9 MM',
                'desc'          => 'PM2-V1 KAL. 9 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
            [
                'name'          => 'PM2-V2 KAL. 9 MM',
                'desc'          => 'PM2-V2 KAL. 9 MM',
                'is_active'     => 1,
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'    => null,
            ],
        ];

        foreach($data as $item) {
            $firearmBrandModel = new FirearmBrandModel();
            $firearmBrandModel->insert($item);
        }
    }
}
