<?php

namespace App\Modules\APIs\Users\Models;

use App\Core\ApiModel;
use App\Modules\APIs\Users\Entities\UserEntity;
use CodeIgniter\I18n\Time;

class UserModel extends ApiModel
{
    protected $table                = 'users';
    protected $allowedFields        = ['fullname', 'username', 'email', 'password', 'level'];

    // Datatables
    protected $columnOrder          = [null, null, 'fullname', 'username', 'email', 'password', 'level', 'last_login', 'created_at', null];
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
        
        return $result->getRow()->count > 0;
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

    public function getAllUser()
    {
        return $this->findAll();
    }

    public function getAllDeletedUser()
    {
        return $this->onlyDeleted()->findAll();
    }

    // public function createUser(array $data) : bool
    // {
    //     $user = new UserEntity();
    //     $user->fill($data);
    //     $this->insert($user);

    //     return $this->db->affectedRows() > 0;
    // }

    public function createUserMultiple(array $data) : int {
        foreach($data as &$item) {
            $item = (array)$item;
            $item['password'] = password_hash($item['password'], PASSWORD_BCRYPT);
            $item = array_merge($item, $this->getCommondFields());
        }

        $this->builder()->insertBatch($data);

        return $this->db->affectedRows();
    }

    public function updateUser(int $id, array $data) : bool
    {
        $user = new UserEntity();
        $user->fill($data);
        $this->update($id, $user);

        return $this->db->affectedRows() > 0;
    }
}
