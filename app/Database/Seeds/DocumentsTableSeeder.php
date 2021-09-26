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
        
        $data = [];
        for($i = 0; $i < 20; $i++) {
            array_push($data, [
                'doc_name'      => 'Berita Acara #'.$i,
                'doc_number'    => $i * 2 . '-000' . $i . '-' . $i*5,
                'doc_date'      => $currentTime->toDateString(),
                'doc_image'     => 'assets/images/test_doc.png',
                'created_at'    => $currentTime->toDateTimeString(),
                'updated_at'    => $currentTime->toDateTimeString(),
                'deletd_at'     => null,
            ]);
        }

        foreach($data as $item) {
            $document = new DocumentModel();
            $document->insert($item);
        }
    }
}
