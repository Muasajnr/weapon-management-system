<?php

namespace App\Database\Seeds;

use App\Models\DocumentModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DocumentsTableSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Time::now();
        
        $data = [
            [
                'doc_name'      => 'Berita Acara #1',
                'doc_number'    => 1 * 2 . '-000' . 1 . '-' . 1*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'borrowing',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #2',
                'doc_number'    => 2 * 2 . '-000' . 2 . '-' . 2*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'borrowing',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #3',
                'doc_number'    => 3 * 2 . '-000' . 3 . '-' . 3*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'borrowing',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #4',
                'doc_number'    => 4 * 2 . '-000' . 4 . '-' . 4*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'borrowing',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #5',
                'doc_number'    => 5 * 2 . '-000' . 5 . '-' . 5*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'borrowing',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #6',
                'doc_number'    => 6 * 2 . '-000' . 6 . '-' . 6*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'returning',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #7',
                'doc_number'    => 7 * 2 . '-000' . 7 . '-' . 7*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'returning',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #8',
                'doc_number'    => 8 * 2 . '-000' . 8 . '-' . 8*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'returning',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #9',
                'doc_number'    => 9 * 2 . '-000' . 9 . '-' . 9*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'returning',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #10',
                'doc_number'    => 10 * 2 . '-000' . 10 . '-' . 10*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'returning',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #11',
                'doc_number'    => 11 * 2 . '-000' . 11 . '-' . 11*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'borrowing',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #12',
                'doc_number'    => 12 * 2 . '-000' . 12 . '-' . 12*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'borrowing',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
            [
                'doc_name'      => 'Berita Acara #13',
                'doc_number'    => 13 * 2 . '-000' . 13 . '-' . 13*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_media'     => 'assets/images/test_doc.png',
                'doc_type'      => 'borrowing',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ],
        ];

        foreach($data as $item) {
            $document = new DocumentModel();
            $document->insert($item);
        }
    }
}
