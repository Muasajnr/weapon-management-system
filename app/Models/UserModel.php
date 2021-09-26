<?php

namespace App\Models;

use App\Core\MyModel;

class UserModel extends MyModel
{
    protected $table                = 'users';
    protected $returnType           = 'App\Entities\UserEntity';
    protected $allowedFields        = ['fullname', 'username', 'email', 'password', 'level', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [];
    protected $columnSearch         = [];


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
}
