<?php

namespace App\Modules\APIs\Auth\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;;
use App\Modules\APIs\Auth\Models\AuthModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class DefaultController extends ApiController
{

    private $authModel;

    public function __construct() {
        parent::__construct();
        
        helper('jwt');
        $this->authModel = new AuthModel();
    }

    /**
     * handle login
     */
    public function login()
    {
        try {
            $rules = ['username'  => 'required', 'password'  => 'required'];
            $messages = [
                'username' => ['required' => 'username is required'],
                'password' => ['required' => 'password is required'],
            ];

            if (!$this->validate($rules, $messages)) {
                $message = 'Validation error!';
                $errors = $this->validator->getErrors();

                throw new ApiAccessErrorException($message, ResponseInterface::HTTP_BAD_REQUEST, $errors);
            }

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $userdata = $this->authModel->getUser($username);
            if (empty($userdata)) {
                $message = 'Gagal login, username atau password salah!';
                throw new ApiAccessErrorException($message, ResponseInterface::HTTP_UNAUTHORIZED);
            }

            if (!password_verify($password, $userdata['password'])) {
                $message = 'Gagal login, username atau password salah!';
                throw new ApiAccessErrorException($message, ResponseInterface::HTTP_UNAUTHORIZED);
            }

            unset($userdata['password']);

            $accessToken = createAccessToken($userdata);
            $refreshToken = createRefreshToken([
                'username'  => $userdata['username'],
            ]);

            if ($this->authModel->isTokenExist('username', $userdata['username'])) {
                $isUpdated = $this->authModel->updateToken($userdata['username'], $refreshToken);
                if (!$isUpdated)
                    throw new ApiAccessErrorException('Terjadi kesalahan!', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $new_data['username']   = $userdata['username'];
                $new_data['token']      = $refreshToken;

                $isAdded = $this->authModel->createToken($new_data);
                if (!$isAdded)
                    throw new ApiAccessErrorException('Terjadi kesalahan!', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
            }

            $this->authModel->setAuthenticatedUser($userdata['username']);
            $this->authModel->updateLastLogin($userdata['id']);

            // set user level session
            $session = session();
            $session->set([
                'userdata'  => $userdata
            ]);

            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Login berhasil!',
                    'data'      => [
                        'access_token' => $accessToken,
                        'refresh_token' => $refreshToken,
                    ],
                ])
                ->setStatusCode(ResponseInterface::HTTP_OK);
        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    /**
     * renew token
     */
    public function renewToken()
    {
        try {
            $rules = ['token' => 'required',];
            $messages = [
                'token' => ['required'  => 'Token field is required',]
            ];

            if (!$this->validate($rules, $messages))
                throw new ApiAccessErrorException('Validation error!', ResponseInterface::HTTP_BAD_REQUEST, $this->validator->getErrors());

            $token = $this->request->getVar('token');

            $username = validateRefreshToken($token);

            if (!$this->authModel->isTokenExist('token', $token))
                throw new ApiAccessErrorException('Token doesn\'t exist!', ResponseInterface::HTTP_NOT_FOUND);

            $userdata = $this->authModel->getUser($username);
            if (!$userdata)
                throw new ApiAccessErrorException('User not found!', ResponseInterface::HTTP_NOT_FOUND);

            unset($userdata['password']);
            $newAccessToken = createAccessToken($userdata);

            return $this->response->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'message'   => 'Token is renewed!',
                'data'      => [
                    'access_token' => $newAccessToken,
                ],
            ])->setStatusCode(ResponseInterface::HTTP_OK);
        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(Exception $e) { 
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        }
    }

    /** handle logout */
    public function logout()
    {
        try {
            $rules = ['token' => 'required'];
            $messages = ['token' => ['required'  => 'Token field is required']];

            if (!$this->validate($rules, $messages))
                throw new ApiAccessErrorException('Validation error!', ResponseInterface::HTTP_BAD_REQUEST, $this->validator->getErrors());

            $token = $this->request->getVar('token');

            $username = validateRefreshToken($token);
            // print_r($token);die();
            if (!$this->authModel->isTokenExist('token', $token))
                throw new ApiAccessErrorException('Token doesn\'t exist!', ResponseInterface::HTTP_NOT_FOUND);

            $isDeleted = $this->authModel->deleteToken($username);
            if (!$isDeleted)
                throw new ApiAccessErrorException('Terjadi kesalahan!', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);

            $this->authModel->updateLastLogout($username);

            // destroy session
            // session_destroy();
            session()->remove(['userdata']);

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NO_CONTENT);
        } catch (ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch (Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
