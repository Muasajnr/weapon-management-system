<?php

namespace App\Core;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

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
        return "<div class=\"custom-control custom-switch custom-switch-off-danger custom-switch-on-success\">
                    <input data-inventory-type-id=\"$id\" name=\"is_active\" type=\"checkbox\" class=\"custom-control-input\" id=\"customSwitch3\" $isChecked>
                    <label class=\"custom-control-label\" for=\"customSwitch3\"></label>
                </div>";
    }
}