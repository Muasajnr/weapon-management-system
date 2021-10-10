<?php

namespace App\Modules\Api\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class UserEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts   = [];

    public function setPassword(string $pass)
    {
        $this->attributes['password'] = password_hash($pass, PASSWORD_BCRYPT);

        return $this;
    }
}
