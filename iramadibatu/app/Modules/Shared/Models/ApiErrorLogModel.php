<?php

namespace App\Modules\Shared\Models;

use App\Core\CoreApiModel;
use CodeIgniter\I18n\Time;

class ApiErrorLogModel extends CoreApiModel
{
    // protected $DBGroup              = 'logs';

    /**
     * add a new error logs
     * 
     * @param array $data
     */
    public function addLogs(array $data)
    {
        $data['issued_at']  = Time::now()->toDateTimeString();
        $data['sys_issued_user'] = $this->authenticatedUser ?? 'public';
        $this->builder('api_errors_logs')
            ->insert($data);
    }
}
