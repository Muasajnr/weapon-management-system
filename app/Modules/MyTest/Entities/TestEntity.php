<?php

namespace App\Modules\MyTest\Entities;

use CodeIgniter\Entity\Entity;

class \TestEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];
}
