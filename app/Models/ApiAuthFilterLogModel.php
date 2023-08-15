<?php

namespace App\Models;

use App\Core\MyModel;

class ApiAuthFilterLogModel extends MyModel
{
    protected $table                = 'api_auth_filter_logs';
    protected $returnType           = 'App\Entities\ApiAuthFilterLogEntity';
    protected $allowedFields        = ['username', 'access_token', 'access_token_key', 'created_at', 'updated_at', 'deleted_at'];
}
