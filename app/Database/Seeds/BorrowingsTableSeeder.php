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
                'borrowing_number'   => uniqid() . '#001',
                'desc'          => 'Peminjaman Senjata #1',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'     => $currentTime->toDateTimeString(),
            ],
            [
                'firearm_id'    => 2,
                'document_id'   => 2,
                'borrowing_number'   => uniqid() . '#002',
                'desc'          => 'Peminjaman Senjata #2',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'     => $currentTime->toDateTimeString(),
            ],
            [
                'firearm_id'    => 3,
                'document_id'   => 3,
                'borrowing_number'   => uniqid() . '#003',
                'desc'          => 'Peminjaman Senjata #3',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'     => $currentTime->toDateTimeString(),
            ],
            [
                'firearm_id'    => 4,
                'document_id'   => 4,
                'borrowing_number'   => uniqid() . '#004',
                'desc'          => 'Peminjaman Senjata #4',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'     => $currentTime->toDateTimeString(),
            ],
            [
                'firearm_id'    => 5,
                'document_id'   => 5,
                'borrowing_number'   => uniqid() . '#005',
                'desc'          => 'Peminjaman Senjata #5',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'     => $currentTime->toDateTimeString(),
            ],
            [
                'firearm_id'    => 6,
                'document_id'   => 11,
                'borrowing_number'   => uniqid() . '#006',
                'desc'          => 'Peminjaman Senjata #6',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'     => null,
            ],
            [
                'firearm_id'    => 7,
                'document_id'   => 12,
                'borrowing_number'   => uniqid() . '#007',
                'desc'          => 'Peminjaman Senjata #7',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'     => null,
            ],
            [
                'firearm_id'    => 8,
                'document_id'   => 13,
                'borrowing_number'   => uniqid() . '#008',
                'desc'          => 'Peminjaman Senjata #8',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deleted_at'     => null,
            ],
        ];

        foreach($data as $item) {
            $borrowing = new BorrowingModel();
            $borrowing->insert($item);
        }
    }
}
