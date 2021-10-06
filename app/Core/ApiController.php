<?php

namespace App\Core;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;

class ApiController extends BaseController
{
    use ResponseTrait;

    protected $rules = [];
    protected $messages = [];

    protected function buildActionButtons($id)
    {
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                    <button type=\"button\" class=\"btn btn-info btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt\"></i></button>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
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
}