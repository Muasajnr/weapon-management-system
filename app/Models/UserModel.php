<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'users';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'App\Entities\UserEntity';
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = ['fullname', 'username', 'email', 'password', 'level', 'created_at', 'updated_at', 'deleted_at'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    // public function checkUser(string $username) : ?object {
    //     return $this->where('username', $username)->first();
    // }

    public function checkUser(string $username) : ?array {
        $sql = 'SELECT `id`, `fullname`, `username`, `email`, `password`, `level` FROM '.$this->table.' WHERE `username` = ? LIMIT 1';
        $result = $this->db->query($sql, [$username]);

        return $result->getRowArray();
    }

    // public function checkUser2(string $username) : object {
    //     $sql = 'SELECT password FROM '.$this->table.' WHERE username = ? LIMIT 1';
    // }

    public function existUser(string $username) : bool {
        $sql = 'SELECT count(*) as count FROM '.$this->table.' WHERE username = ? LIMIT 1';
        $result = $this->db->query($sql, [$username]);
        
        return $result->getRow()->count > 0 ? true : false;
    }

    public function findByUsername(string $username) : object {
        $userdata = $this->where('username', $username)->first();
        if (!$userdata) throw new Exception('Unauthorized');
        return $userdata;
    }
}
