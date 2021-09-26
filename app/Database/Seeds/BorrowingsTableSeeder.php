<?php

namespace App\Database\Seeds;

use App\Models\BorrowingModel;
use App\Models\DocumentModel;
use App\Models\FirearmModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class BorrowingsTableSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Time::now();

        $data = [
            [
                'firearm_id'    => 1,
                'document_id'   => 1,
                'desc'          => 'Peminjaman Senjata #1',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'firearm_id'    => 2,
                'document_id'   => 2,
                'desc'          => 'Peminjaman Senjata #2',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'firearm_id'    => 3,
                'document_id'   => 3,
                'desc'          => 'Peminjaman Senjata #3',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'firearm_id'    => 4,
                'document_id'   => 4,
                'desc'          => 'Peminjaman Senjata #4',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'firearm_id'    => 5,
                'document_id'   => 5,
                'desc'          => 'Peminjaman Senjata #5',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
        ];

        foreach($data as $item) {
            $borrowing = new BorrowingModel();
            $borrowing->insert($item);
        }
    }
}
