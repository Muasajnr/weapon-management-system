<?php

namespace App\Database\Seeds;

use App\Models\FirearmBrandModel;
use App\Models\FirearmModel;
use App\Models\FirearmTypeModel;
use App\Models\InventoryTypeModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class FirearmsTableSeeder extends Seeder
{
    public function run()
    {
        $currentTime = Time::now();
        $conditions = [
            'good',
            'damage',
            'unknown'
        ];

        $data = [];
        for($i = 0; $i < 50; $i++) {
            $randIndex = random_int(0, count($conditions) - 1);
            
            array_push($data, [
                'inventory_type_id' => $this->getRandomInventoryType(),
                'firearms_type_id'  => $this->getRandomFirearmType(),
                'firearms_brand_id' => $this->getRandomFirearmBrand(),
                'firearms_number'   => $i . '-' . uniqid() . '__000' . $i*2,
                'bpsa_number'       => uniqid(),
                'condition'         => $conditions[$randIndex],
                'description'       => 'desc ' . $i,
                'created_at'        => $currentTime->toDateTimeString(),
                'updated_at'        => $currentTime->toDateTimeString(),
                'deletd_at'         => null,
            ]);
        }

        foreach($data as $item) {
            $firearm = new FirearmModel();
            $firearm->insert($item);
        }
    }

    private function getRandomInventoryType()
    {
        $inventoryTypeModel = new InventoryTypeModel();
        $inventoryTypeData = $inventoryTypeModel->findAll();

        $randIndex = random_int(0, count($inventoryTypeData) - 1);

        return $inventoryTypeData[$randIndex]->id;
    }

    private function getRandomFirearmType()
    {
        $firearmTypeModel = new FirearmTypeModel();
        $firearmTypeData = $firearmTypeModel->findAll();

        $randIndex = random_int(0, count($firearmTypeData) - 1);

        return $firearmTypeData[$randIndex]->id;
    }

    private function getRandomFirearmBrand()
    {
        $firearmBrandModel = new FirearmBrandModel();
        $firearmBrandData = $firearmBrandModel->findAll();

        $randIndex = random_int(0, count($firearmBrandData) - 1);

        return $firearmBrandData[$randIndex]->id;
    }
}
