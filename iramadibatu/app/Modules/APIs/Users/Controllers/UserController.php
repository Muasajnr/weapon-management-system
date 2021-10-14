<?php

namespace App\Modules\APIs\Users\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\Users\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class UserController extends ApiController
{

    private $userModel;

    
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        //
    }

    public function get($id)
    {
        $data = $this->userModel->getOne($id);
        unset($data['password']);
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $data
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function updatePassword($id)
    {
        try {
            if (!$this->request->isAJAX())
                throw new ApiAccessErrorException(
                    'Invalid Request!', 
                    ResponseInterface::HTTP_BAD_REQUEST
                );
            
            $rules = [
                'password' => 'required',
                'confirm_password' => 'required|matches[password]'
            ];
            
            if (!$this->validate($rules))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            $data = $this->request->getVar();
            
            $this->userModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $data = (array) $data;
            unset($data['confirm_password']);
    
            $isUpdated = $this->userModel->updatePassword((int)$id, $data['password']);
            if (!$isUpdated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
    
            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Password telah diubah!'
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
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->userModel->datatable($posts);
        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['id']."\">{$num}.";
            $row[]      = $item['fullname'] ?? '-';
            $row[]      = $item['username'] ?? '-';
            $row[]      = $item['email'] ?? '-';
            $row[]      = "<span class=\"badge badge-primary\">".$item['level'] ?? '-'."</span>";
            $row[]      = $item['last_login'] ?? '-';
            $row[]      = $item['created_at'] ?? '-';
            $row[]      = $this->buildCustomButtonActions($item['id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->userModel->countDatatableData($posts);
        $output['recordsFiltered']  = $this->userModel->countDatatableFilteredData();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    /**create */
    public function create()
    {
        try {
            if (!$this->request->isAJAX())
                throw new ApiAccessErrorException(
                    'Invalid Request!', 
                    ResponseInterface::HTTP_BAD_REQUEST
                );
            
            $rules = [
                'fullname' => 'required',
                'username' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required',
                'level' => 'required|in_list[admin,user]',
            ];
            // print_r($this->request->getVar());die();
            if (!$this->validate($rules))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            $data = $this->request->getVar();
            
            $this->userModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $data = (array) $data;
            $data['password']   = password_hash($data['password'], PASSWORD_BCRYPT);
            $isAdded = $this->userModel->createData($data);
            if (!$isAdded)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
    
            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_CREATED,
                    'message'   => 'Data telah ditambahkan!'
                ])
                ->setStatusCode(ResponseInterface::HTTP_CREATED);
        } catch(ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch(Exception $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**update */
    public function update($id)
    {
        try {
            if (!$this->request->isAJAX())
                throw new ApiAccessErrorException(
                    'Invalid Request!', 
                    ResponseInterface::HTTP_BAD_REQUEST
                );
            
            $rules = [
                'fullname' => 'required',
                'username' => 'required',
                'email' => 'required|valid_email',
                'level' => 'required|in_list[admin,user]',
            ];

            if (!$this->validate($rules))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            if(!$this->userModel->isExist($id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );

            $this->userModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $data = $this->request->getVar();
            $isUpdated = $this->userModel->updateData($id, (array) $data);
            if (!$isUpdated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );

            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Data telah diperbaharui!'
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
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**delete */
    public function delete($id)
    {
        try {
            if (!$this->userModel->isExist((int) $id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );

            $isDeleted = $this->userModel->deleteData($id);
            if (!$isDeleted)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Data telah dihapus!'
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
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**delete multiple */
    public function deleteMultiple()
    {
        try {
            if (!$this->request->isAJAX())
                throw new ApiAccessErrorException(
                    'Invalid Request!', 
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        
            $rules      = ['ids' => 'required'];
            $messages   = [
                'ids' => ['required' => 'ids is required']
            ];
            
            if (!$this->validate($rules, $messages))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );

            $ids = $this->request->getVar('ids');
            
            $affectedRows = $this->userModel->deleteMultipleData($ids);
            if ($affectedRows != count($ids))
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );
            
            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Data telah dihapus!'
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
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function buildCustomButtonActions($id)
    {
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-warning btn-xs mr-2\" data-item-id=\"$id\"><i class=\"fas fa-key mr-1\"></i>Ganti Password</button>
                    <button type=\"button\" class=\"btn btn-primary btn-xs mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye mr-1\"></i>Detail</button>
                    <button type=\"button\" class=\"btn btn-info btn-xs mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt mr-1\"></i>Edit</button>
                    <button type=\"button\" class=\"btn btn-danger btn-xs\" data-item-id=\"$id\"><i class=\"fas fa-trash mr-1\"></i>Hapus</button>
                </div>";
    }
}
