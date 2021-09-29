<?php

namespace App\Database\Seeds;

use App\Models\ReturningModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ReturningsTableSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Time::now();

        $data = [
            [
                'borrowing_id'  => 1,
                'document_id'   => 6,
                'desc'          => 'Pengembalian Senjata #1',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'borrowing_id'  => 2,
                'document_id'   => 7,
                'desc'          => 'Pengembalian Senjata #2',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'borrowing_id'  => 3,
                'document_id'   => 8,
                'desc'          => 'Pengembalian Senjata #3',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'borrowing_id'  => 4,
                'document_id'   => 9,
                'desc'          => 'Pengembalian Senjata #4',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'borrowing_id'  => 5,
                'document_id'   => 10,
                'desc'          => 'Pengembalian Senjata #5',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
        ];

        foreach($data as $item) {
            $returning = new ReturningModel();
            $returning->insert($item);
        }
    }
}
