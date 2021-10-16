<?php

namespace App\Modules\APIs\Auth\Models;

use App\Core\CoreApiModel;
use CodeIgniter\I18n\Time;

class AuthModel extends CoreApiModel
{
    /**
     * get user by a username
     * 
     * @param string $username
     * 
     * @return bool
     */
    public function getUser(string $username) : array {
        $result = $this->builder('users')
            ->select('id, fullname, username, email, password, level')
            ->where('username', $username)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        if (is_null($result))
            return [];
        
        return $result;
    }

    /**
     * check if user refresh token by username
     * 
     * @param string $username
     * 
     * @return bool
     */
    public function isTokenAlreadyExist(string $username) : bool
    {
        $result = $this->builder('users_tokens')
            ->selectCount('*', 'count')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (is_null($result))
            return false;

        return $result['count'];
    }

    /**
     * check if user refresh token exist by token
     * 
     * @param string $token
     * 
     * @return bool
     */
    public function isTokenExist_old(string $token) : bool
    {
        $result = $this->builder('users_tokens')
            ->selectCount('*', 'count')
            ->where('token', $token)
            ->get()
            ->getRowArray();

        if (is_null($result))
            return false;

        return $result['count'];
    }
    
    /**
     * check if user's refhres token exist
     * 
     * @param string $checkBy
     * @param string $checkByValue
     * 
     * @return bool
     */
    public function isTokenExist(string $key, string $val) : bool
    {
        $result = $this->builder('users_tokens')
            ->selectCount('*', 'count')
            ->where($key, $val)
            ->get()
            ->getRowArray();

        if (is_null($result))
            return false;

        return $result['count'];
    }

    /**
     * update an existing token
     * 
     * @param string $username
     * @param string $token
     * 
     * @return bool
     */
    public function updateToken(string $username, string $token) : bool
    {
        $result = $this->builder('users_tokens')
            ->set([
                'token' => $token,
                'updated_at' => Time::now()->toDateTimeString(),
            ])
            ->where('username', $username)
            ->update();
    
        return $result;
    }

    /**
     * create a new token
     * 
     * @param array $data
     * 
     * @return bool
     */
    public function createToken(array $data) : bool
    {
        $now = Time::now();
        $data['created_at'] = $now->toDateTimeString();
        $data['updated_at'] = $now->toDateTimeString();
        
        $result = $this->builder('users_tokens')
            ->insert($data);
        
        return $result;
    }

    /**
     * update last users logged in
     * 
     * @param int $id
     * 
     * @return void
     */
    public function updateLastLogin(int $id)
    {
        $now = Time::now();
        $this->builder('users')
            ->set([
                'last_login' => $now->toDateTimeString(),
                'updated_at'    => $now->toDateTimeString(),
                'sys_updated_user' => $this->authenticatedUser,
            ])
            ->where('id', $id)
            ->update();
    }

    /**
     * update last logout
     * 
     * @param string $username
     * 
     * @return void
     */
    public function updateLastLogout(string $username)
    {
        $now = Time::now();
        $this->builder('users')
            ->set([
                'last_logout' => $now->toDateTimeString(),
                'updated_at'    => $now->toDateTimeString(),
                'sys_updated_user' => $this->authenticatedUser,
            ])
            ->where('username', $username)
            ->update();
    }
    
    /**
     * delete user's token
     * 
     * @param string $username
     * 
     * @return void
     */
    public function deleteToken(string $username) : bool
    {
        $result = $this->builder('users_tokens')
            ->where('username', $username)
            ->delete();
        return $result;
    }
}
