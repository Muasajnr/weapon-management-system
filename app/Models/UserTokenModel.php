<?php

namespace App\Models;

use CodeIgniter\Model;

class UserTokenModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'users_tokens';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['username', 'token'];

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

    public function checkToken(string $token) : bool
    {
        $sql = 'SELECT `id`, `token` FROM '.$this->table.' WHERE `token` = ?';
        $result = $this->query($sql, [$token]);

        return $result->getRow() ? true : false;
    }

    public function checkUsername(string $username) : bool
    {
        $result = $this->where('username', $username)->first();
        return $result ? true : false;
    }

    public function updateToken(string $username, string $token) : bool
    {
        $this->where('username', $username)
                    ->set(['token' => $token])
                    ->update();
        return $this->db->affectedRows() > 0 ? true : false;
    }

    public function deleteToken(string $username) : bool
    {
        $this->where('username', $username)->delete();

        return $this->db->affectedRows() > 0 ? true : false;
    }
}
