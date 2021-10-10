<?php

namespace App\Modules\Api\Controllers;

use App\Controllers\BaseController;
use App\Modules\Api\Entities\UserTokenEntity;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\UserTokenModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class ApiAuthController extends BaseController
{

    use ResponseTrait;

    public function __construct() {
        helper('jwt');
    }

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
            if (!$userdata)
                return $this->failUnauthorized('Gagal login, username atau password salah!', 'unauthorized');
            
            if (!password_verify($password, $userdata['password']))
                return $this->failUnauthorized('Gagal login, username atau password salah!', 'unauthorized');
            
            unset($userdata['password']);

            $jwt_access_token = createAccessToken($userdata);
            $jwt_refresh_token = createRefreshToken([
                'username'  => $userdata['username'],
            ]);

            $user_token_model = new UserTokenModel();
            if ($user_token_model->checkUsername($userdata['username'])) {
                $is_updated = $user_token_model->updateToken($userdata['username'], $jwt_refresh_token);
                if (!$is_updated) 
                    $this->fail('Terjadi kesalahan!', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $user_token_new = new UserTokenEntity();
                $user_token_new->username = $userdata['username'];
                $user_token_new->token = $jwt_refresh_token;
                $user_token_model->insert($user_token_new);
            }

            $usermodel->updateLastLogin($userdata['id']);

            return $this->respond([
                'status'    => ResponseInterface::HTTP_OK,
                'code'      => 'success',
                'message'   => 'Login is successful!',
                'data'      => [
                    'access_token' => $jwt_access_token,
                    'refresh_token' => $jwt_refresh_token,
                ],
            ], ResponseInterface::HTTP_OK);
        }
    }

    public function renewAccessToken()
    {
        $rules = [
            'token' => 'required',
        ];

        $messages = [
            'token' => [
                'required'  => 'Token field is required',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed');
        } else {
            try {
                $token = $this->request->getVar('token');

                $username = validateRefreshToken($token);

                $user_token_model = new UserTokenModel();
                if (!$user_token_model->checkToken($token)) {
                    return $this->failNotFound('Token doesn\'t exist!', 'not_found');
                } else {
                    $user_model = new UserModel();
                    $userdata = $user_model->checkUser($username);
                    
                    if (!$userdata) {
                        return $this->failNotFound('User not found!', 'not_found');
                    } else {
                        unset($userdata['password']);
                        $new_access_token = createAccessToken($userdata);

                        return $this->respond([
                            'status'    => ResponseInterface::HTTP_OK,
                            'code'      => 'success',
                            'message'   => 'Token is renewed!',
                            'data'      => [
                                'access_token' => $new_access_token,
                            ],
                        ], ResponseInterface::HTTP_OK);
                    }
                }
            } catch (\Exception $e) {
                return $this->fail($e->getMessage(), ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function handleLogout()
    {
        $rules = ['token' => 'required'];
        $messages = ['token' => ['required'  => 'Token field is required']];

        if (!$this->validate($rules, $messages))
            return $this->failValidationErrors($this->validator->getErrors(), 'Validation Failed!');

        $token = $this->request->getVar('token');

        $username = validateRefreshToken($token);

        $user_token_model = new UserTokenModel();
        if (!$user_token_model->checkToken($token))
            return $this->failNotFound('Token doesn\'t exist!', 'not_found');

        $is_deleted = $user_token_model->deleteToken($username);
        if (!$is_deleted)
            $this->fail('Terjadi kesalahan!', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);

        $usermodel = new UserModel();
        $usermodel->updateLastLogout($username);

        return $this->respondNoContent('User logged out!');
    }
}
