<?php

namespace App\Modules\Api\Models;

use App\Core\ApiModel;

class UserTokenModel extends ApiModel
{
    protected $table                = 'users_tokens';
    protected $returnType           = 'array';
    protected $allowedFields        = ['username', 'token'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = '';
    protected $updatedField         = '';
    protected $deletedField         = '';

    protected $beforeInsert         = [];

    // Datatables
    protected $columnOrder          = ['username', 'token'];
    protected $columnSearch         = ['username', 'token'];

    public function checkToken(string $token) : bool
    {
        $sql = 'SELECT `id`, `token` FROM '.$this->table.' WHERE `token` = ?';
        $result = $this->query($sql, [$token]);

        return $result->getRow() ? true : false;
    }

    public function checkUsername(string $username) : bool
    {
        // $result = $this->where('username', $username)->first();
        $sql = 'SELECT COUNT(*) as count FROM '.$this->table.' WHERE username = ? LIMIT 1';
        $result = $this->query($sql, [$username]);
        // print_r($result->getRowArray());die();
        return $result->getRowArray()['count'] > 0;
    }

    public function updateToken(string $username, string $token) : bool
    {
        $this->where('username', $username)
                    ->set(['token' => $token])
                    ->update();
        return $this->db->affectedRows() > 0;
    }

    public function deleteToken(string $username) : bool
    {
        $this->where('username', $username)->delete();

        return $this->db->affectedRows() > 0;
    }

}
