<?php

namespace App\Modules\APIs\Auth\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class AuthLogModel extends Model
{
    protected $DBGroup              = 'logs';

    protected $loggedUser           = null;

    public function setLoggedUser(string $logged_user)
    {
        $this->loggedUser = $logged_user;
    }

    /**
     * add a new error logs
     * 
     * @param array $data
     */
    public function addLogs(array $data)
    {
        $data['issued_at']  = Time::now()->toDateTimeString();
        $data['sys_issued_user'] = $this->loggedUser ?? 'public';
        $this->builder('api_errors_logs')
            ->insert($data);
    }
}
