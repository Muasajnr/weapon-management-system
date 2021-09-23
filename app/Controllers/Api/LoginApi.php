<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class LoginApi extends BaseController
{
    use ResponseTrait;

    public function handleLogin()
    {
        $rules = [
            'username'  => 'required',
            'password'  => 'required'
        ];

        $messages = [
            'username' => [
                'required' => 'username is required',
            ],
            'password' => [
                'required' => 'password is required',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed');
        } else {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $usermodel = new UserModel();
            $userdata = $usermodel->checkUser($username);
            if (!$userdata) {
                return $this->failUnauthorized('Gagal login, username atau password salah!', 'unauthorized');
            } else {
                if (!password_verify($password, $userdata['password'])) {
                    return $this->failUnauthorized('Gagal login, username atau password salah!', 'unauthorized');
                } else {
                    $iat = time();
                    $nbf = $iat + 10;
                    $exp = $iat + 3600;

                    $payload = [
                        'iss'   => 'The_claim',
                        'aud'   => 'The_Aud',
                        'iat'   => $iat,
                        'nbf'   => $nbf,
                        'exp'   => $exp,
                        'data'  => $userdata,
                    ];

                    $jwt_token = JWT::encode($payload, JWT_KEY);

                    return $this->respond([
                        'status'    => 200,
                        'code'      => 'success',
                        'message'   => 'Login is successful!',
                        'data'      => [
                            'token' => $jwt_token,
                        ],
                    ], 200);
                }
            }
        }
    }
}
