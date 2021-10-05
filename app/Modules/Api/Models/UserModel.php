<?php

namespace App\Modules\Api\Models;

use App\Core\ApiModel;
use CodeIgniter\I18n\Time;

class UserModel extends ApiModel
{
    protected $table                = 'users';
    protected $returnType           = 'App\Modules\Api\Entities\UserEntity';
    protected $allowedFields        = ['fullname', 'username', 'email', 'password', 'level'];

    // Datatables
    protected $columnOrder          = ['fullname', 'username', 'email', 'password', 'level'];
    protected $columnSearch         = ['fullname', 'username', 'email', 'password', 'level'];


    public function __construct()
    {
        parent::__construct();
    }

    public function checkUser(string $username) : ?array {
        $sql = 'SELECT `id`, `fullname`, `username`, `email`, `password`, `level` FROM '.$this->table.' WHERE `username` = ? LIMIT 1';
        $result = $this->db->query($sql, [$username]);

        return $result->getRowArray();
    }

    public function existUser(string $username) : bool {
        $sql = 'SELECT count(*) as count FROM '.$this->table.' WHERE username = ? LIMIT 1';
        $result = $this->db->query($sql, [$username]);
        
        return $result->getRow()->count > 0 ? true : false;
    }

    public function findByUsername(string $username) : object {
        $userdata = $this->where('username', $username)->first();
        if (!$userdata) throw new \Exception('Unauthorized');
        return $userdata;
    }

    public function updateLastLogin($id) {
        $this->builder()->where('id', $id);
        $this->builder()->set('last_login', Time::now()->toDateTimeString());
        $this->builder()->update();
    }

    public function updateLastLogout($username) {
        $this->builder()->where('username', $username);
        $this->builder()->set('last_logout', Time::now()->toDateTimeString());
        $this->builder()->update();
    }
}
