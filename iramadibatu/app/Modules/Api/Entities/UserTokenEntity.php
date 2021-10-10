<?php

namespace App\Modules\Api\Entities;

use CodeIgniter\Entity\Entity;

class UserTokenEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];
}
