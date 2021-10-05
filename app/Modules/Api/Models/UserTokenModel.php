<?php

namespace App\Modules\Api\Models;

use App\Core\ApiModel;

class UserTokenModel extends ApiModel
{
    protected $table                = 'users_tokens';
    protected $returnType           = 'App\Modules\Api\Entities\UserEntity';
    protected $allowedFields        = ['username', 'token'];

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
