<?php

namespace App\Core;

use App\Controllers\BaseController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\Shared\Models\ApiErrorLogModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;

class ApiController extends BaseController
{

    protected $rules = [];
    protected $messages = [];

    private $defaultModel;
    protected $logModel;

    
    public function __construct(string $defaultModel = '')
    {
        if (!empty($defaultModel)) {
            $this->defaultModel = new $defaultModel();
        }

        $this->logModel = new ApiErrorLogModel();
    }

    protected function setDefaultModel(string $defaultModel)
    {
        $this->defaultModel = new $defaultModel();
    }

    protected function defaultModel()
    {
        return $this->defaultModel;
    }

    protected function buildActionButtons($id)
    {
        if (session('userdata')['level'] === 'admin')
            return "<div class=\"text-center\">
                        <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                        <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                        <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                    </div>";
        
        if (session('userdata')['level'] === 'admin')
            return "<div class=\"text-center\">
                        <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                    </div>";

        return "<p><strong>forbidden</strong></p>";
    }

    protected function buildStatusSwitch($id, $isActive)
    {
        $isChecked = $isActive ? 'checked' : '';
        return "<div class=\"custom-control custom-switch custom-switch-off-danger custom-switch-on-success text-center\">
                    <input data-item-id=\"$id\" name=\"is_active\" type=\"checkbox\" class=\"custom-control-input\" id=\"customSwitch3-$id\" $isChecked>
                    <label class=\"custom-control-label\" for=\"customSwitch3-$id\"></label>
                </div>";
    }

    protected function validateData(RequestInterface $request) : array
    {
        $validation = Services::validation();
        $validation->setRules($this->rules, $this->messages);
        
        return [
            'is_valid'  => $validation->withRequest($request)->run(),
            'errors'    => $validation->getErrors() ?? []
        ];
    }

    protected function generateFileName($fileExt, $prefix = 'file_') : string
    {
        $now = Time::now();
        return $prefix . $now->toLocalizedString('yyyyMMdd_HHmmss') . '.' . $fileExt;
    }

    protected function getErrorOutput($exception, IncomingRequest $request) : array
    {
        $data = [
            'req_body'  => null,
            'req_headers'   => null,
            'req_method' => $request->getMethod(),
            'req_ip_addr'   => $request->getIPAddress(),
            'req_is_ajax'   => $request->isAJAX() ?? 0,
            'req_path' => $request->getPath(),
            'message'   => $exception->getMessage(),
            'code'  => $exception->getCode(),
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ];

        $errors = [];
        if ($exception instanceof ApiAccessErrorException)
            $errors = $exception->getErrors();

        $this->logModel->addLogs($data);

        return [
            'status'    => $exception->getCode(),
            'message'   => $exception->getMessage(),
            'errors'    => $errors,
        ];
    }
}