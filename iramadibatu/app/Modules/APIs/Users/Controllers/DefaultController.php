<?php

namespace App\Modules\APIs\Users\Controllers;

use App\Core\ApiController;

class DefaultController extends ApiController
{
    // public function __construct()
    // {
    //     $this->rules = [
    //         'fullname'  => 'required|string',
    //         'username'  => 'required|string',
    //         'email'  => 'required|string|valid_email',
    //         'password'  => 'required|string',
    //         'level'  => 'required|in_list[admin,user]'
    //     ];
    //     $this->messages = [
    //         'fullname'  => [
    //             'required'  => 'fullname tidak boleh kosong!',
    //             'string'  => 'fullname harus berupa string!',
    //         ],
    //         'username'  => [
    //             'required'  => 'username tidak boleh kosong!',
    //             'string'  => 'username harus berupa string!',
    //         ],
    //         'email'  => [
    //             'required'  => 'email tidak boleh kosong!',
    //             'string'  => 'email harus berupa string!',
    //             'valid_email'  => 'email yang dimasukkan tidak valid!',
    //         ],
    //         'password'  => [
    //             'required'  => 'password tidak boleh kosong!',
    //             'string'  => 'password harus berupa string!',
    //         ],
    //         'level'  => [
    //             'required'  => 'level tidak boleh kosong!',
    //             'string'  => 'level harus berupa string!',
    //         ],
    //     ];
    // }
    

    // /**
    //  * get all active user
    //  */
    // public function index()
    // {
    //     $userModel = new UserModel();
    //     return $this->respond([
    //         'status'    =>  ResponseInterface::HTTP_OK,
    //         'data'      => $userModel->getAllUser()
    //     ], ResponseInterface::HTTP_OK);
    // }

    // // get all non-active user
    // public function getAllDeletedUser()
    // {
    //     $userModel = new UserModel();
    //     return $this->respond([
    //         'status'    => ResponseInterface::HTTP_OK,
    //         'data'      => $userModel->getAllDeletedUser()
    //     ], ResponseInterface::HTTP_OK);
    // }

    // // get single user
    // public function getOne($id)
    // {
    //     $userModel = new UserModel();
    //     $userdata = $userModel->getOne($id);
    //     if (!$userdata)
    //         return $this->failNotFound('Data not found!');
        
    //     return $this->respond([
    //         'status'    => ResponseInterface::HTTP_OK,
    //         'data'      => $userdata,
    //     ], ResponseInterface::HTTP_OK);
    // }

    // // datatables
    // public function datatables()
    // {
    //     $draw               = $this->request->getPost('draw');
    //     $searchQuery        = $this->request->getPost('search');
    //     $length             = $this->request->getPost('length');
    //     $start              = $this->request->getPost('start');
    //     $order              = $this->request->getPost('order') ?? [];

    //     $resData            = [];

    //     $userModel = new UserModel();
    //     $data               = $userModel->getDatatables($searchQuery['value'], $start, $length, $order);
    //     $recordsTotal       = $userModel->getTotalRecords($searchQuery['value'], $order);
    //     $recordsFiltered    = $userModel->getTotalFilteredRecords();

    //     $num = $start;
    //     foreach($data as $item) {
    //         $num++;

    //         $row        = [];
    //         $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"$item->id\"></div>";
    //         $row[]      = "<input type=\"hidden\" value=\"$item->id\">{$num}.";
    //         $row[]      = "{$item->fullname}";
    //         $row[]      = "{$item->username}";
    //         $row[]      = "{$item->email}";
    //         $row[]      = "{$item->level}";
    //         $row[]      = "{$item->last_login}";
    //         $row[]      = "{$item->created_at}";
    //         $row[]      = $this->buildActionButtons($item->id);

    //         $resData[] = $row;
    //     }

    //     $output = [
    //         'draw'  => $draw,
    //         'recordsTotal'  => $recordsTotal,
    //         'recordsFiltered' => $recordsFiltered,
    //         'data'  => $resData,
    //     ];

    //     return $this->respond($output, ResponseInterface::HTTP_OK);
    // }

    // // create new user
    // public function create()
    // {
    //     $validation = $this->validateData($this->request);
    //     if (!$validation['is_valid'])
    //         return $this->failValidationErrors($validation['errors']);
        
    //     $data = $this->request->getVar();
    //     $userModel = new UserModel();

    //     $loggedUser = $this->request->header('logged_user')->getValue();
    //     $userModel->setLoggedUsername($loggedUser);

    //     $isAdded = $userModel->createUser((array) $data);
    //     if (!$isAdded)
    //         return $this->fail('Terjadi kesalahan!');

    //     return $this->respondCreated([
    //         'status'    => ResponseInterface::HTTP_CREATED,
    //         'message'   => 'User telah ditambahkan!'
    //     ]);
    // }

    // // create user multiple
    // public function createMultiple()
    // {
    //     $rules = ['data' => 'required'];
    //     if (!$this->validate($rules))
    //         return $this->failValidationErrors($this->validator->getErrors());

    //     $data = $this->request->getVar('data');

    //     $userModel = new UserModel();
    //     $loggedUser = $this->request->header('logged_user')->getValue();
    //     $userModel->setLoggedUsername($loggedUser);

    //     $affectedRows = $userModel->createUserMultiple((array)$data);
    //     if ($affectedRows == 0)
    //         return $this->fail('Terjadi kesalahan!');
        
    //     if ($affectedRows != count($data))
    //         return $this->respond([
    //             'status'    => ResponseInterface::HTTP_OK,
    //             'message'   => $affectedRows . ' data telah ditambahkan'
    //         ], ResponseInterface::HTTP_OK);

    //     return $this->respond([
    //         'status'    => ResponseInterface::HTTP_OK,
    //         'message'   => 'Semua data telah ditambahkan.'
    //     ], ResponseInterface::HTTP_OK);
    // }

    // // edit user
    // public function update($id)
    // {
    //     $validation = $this->validateData($this->request);
    //     if (!$validation['is_valid'])
    //         return $this->failValidationErrors($validation['errors']);
        
    //     $data = $this->request->getVar();

    //     $userModel = new UserModel();
    //     if (!$userModel->isExist($id))
    //         return $this->failNotFound('ID tidak ditemukan!');

    //     $isUpdated = $userModel->updateUser($id, (array) $data);
    //     if (!$isUpdated)
    //         return $this->fail('Terjadi kesalahan!');

    //     return $this->respondUpdated([
    //         'status'    => ResponseInterface::HTTP_OK,
    //         'message'   => 'User telah diperbaharui!'
    //     ]);
    // }

    // // delete user
    // public function delete($id)
    // {
    //     $userModel = new UserModel();
    //     if (!$userModel->isExist((int) $id))
    //         return $this->failNotFound('Not found!');

    //     $isDeleted = $userModel->deleteData($id);
    //     if (!$isDeleted) {
    //         return $this->fail('Terjadi kesalahan!');
    //     } else {
    //         return $this->respondDeleted([
    //             'success'   => ResponseInterface::HTTP_OK,
    //             'message'   => 'Data telah dihapus!'
    //         ]);
    //     }
    // }

    // // delete multiple user
    // public function deleteMultiple()
    // {
    //     if (!$this->validate(['ids' => 'required']))
    //         return $this->failValidationErrors($this->validator->getErrors());
        
    //     $data = $this->request->getVar();
        
    //     $userModel = new UserModel();
    //     $affectedRows = $userModel->deleteMultipleData($data->ids);
    //     if ($affectedRows != count($data->ids))
    //         return $this->fail('Only some data gets deleted!');
            
    //     return $this->respondDeleted([
    //         'success'   => ResponseInterface::HTTP_OK,
    //         'message'   => 'Data yang dipilih telah terhapus!'
    //     ]);
    // }

    // // restore a user
    // public function restore($id)
    // {
    //     // restore operation
    // }
    // // restore multiple user
    // public function restoreMultiple()
    // {
    //     // restore operation
    // }

    // // purge user
    // public function purge($id)
    // {
    //     $userModel = new UserModel();
    //     if (!$userModel->isExistDeleted((int) $id))
    //         return $this->failNotFound('Not found!');

    //     $isPurged = $userModel->purgeData($id);
    //     if (!$isPurged) {
    //         return $this->fail('Terjadi kesalahan!');
    //     } else {
    //         return $this->respondDeleted([
    //             'success'   => ResponseInterface::HTTP_OK,
    //             'message'   => 'Data telah dihapus secara permanen!'
    //         ]);
    //     }
    // }

    // // purge multiple user
    // public function purgeMultiple()
    // {
    //     if (!$this->validate(['ids' => 'required']))
    //         return $this->failValidationErrors($this->validator->getErrors());
        
    //     $data = $this->request->getVar();
        
    //     $userModel = new UserModel();
    //     $userModel->purgeMultipleData($data->ids);
        
    //     return $this->respondDeleted([
    //         'success'   => ResponseInterface::HTTP_OK,
    //         'message'   => 'Data yang dipilih telah terhapus secara permanane!'
    //     ]);
    // }
}
