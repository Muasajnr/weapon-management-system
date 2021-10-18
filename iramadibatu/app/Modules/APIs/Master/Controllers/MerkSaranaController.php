<?php

namespace App\Modules\APIs\Master\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\Master\Models\MerkSaranaModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class MerkSaranaController extends ApiController
{
    private $MSModel;

    public function __construct()
    {
        parent::__construct();
        $this->MSModel   = new MerkSaranaModel();
    }
    
    public function index()
    {
        $allData = $this->MSModel->getAll();
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $allData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    /**datatables */
    public function datatables()
    {
        $posts      = $this->request->getPost();
        $data       = $this->MSModel->datatable($posts);
        $resData    = [];

        $num = $posts['start'];
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['id']."\">{$num}.";
            $row[]      = $item['name'];
            $row[]      = $item['desc'];
            $row[]      = $this->buildStatusSwitch($item['id'], $item['is_active']);
            $row[]      = $item['created_at'];
            $row[]      = $this->buildCustomButtonActions($item['id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->MSModel->countDatatableData($posts);
        $output['recordsFiltered']  = $this->MSModel->countDatatableFilteredData();
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
            
            $rules = ['name' => 'required', 'desc' => 'required', 'is_active' => 'required'];
    
            if (!$this->validate($rules))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            $data = $this->request->getVar();
            
            $this->MSModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $newData['name']    = $data->name;
            $newData['is_active'] = $data->is_active;
            $newData['desc']    = $data->desc;

            $isAdded = $this->MSModel->createData($newData);
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

    /**set_active */
    public function setStatus($id)
    {
        try {
            if (!$this->request->isAJAX())
                throw new ApiAccessErrorException(
                    'Invalid Request!', 
                    ResponseInterface::HTTP_BAD_REQUEST
                );
            
            $rules      = ['is_active' => 'required'];
    
            if (!$this->validate($rules))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            if(!$this->MSModel->isExist($id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );
            
            $isActive = $this->request->getVar('is_active');
            $isUpdated = $this->MSModel->setActive($id, $isActive);
            if (!$isUpdated)
                throw new ApiAccessErrorException(
                    'Terjadi kesalahan!', 
                    ResponseInterface::HTTP_INTERNAL_SERVER_ERROR
                );

            return $this->response
                ->setJSON([
                    'status'    => ResponseInterface::HTTP_OK,
                    'message'   => 'Status telah diperbaharui!'
                ])
                ->setStatusCode(ResponseInterface::HTTP_OK);
        } catch (ApiAccessErrorException $e) {
            $errOutput = $this->getErrorOutput($e, $this->request);
            return $this->response
                ->setJSON($errOutput)
                ->setStatusCode($e->getCode());
        } catch (Exception $e) {
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
            
            $rules = ['name' => 'required', 'desc' => 'required', 'is_active' => 'required'];

            if (!$this->validate($rules))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            if(!$this->MSModel->isExist($id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );

            $this->MSModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $data = $this->request->getVar();

            $updatedData['name']    = $data->name;
            $updatedData['is_active'] = $data->is_active;
            $updatedData['desc']    = $data->desc;

            $isUpdated = $this->MSModel->updateData($id, $updatedData);
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
            if (!$this->MSModel->isExist((int) $id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );

            $isDeleted = $this->MSModel->deleteData($id);
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

            if (!$this->validate($rules))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );

            $ids = $this->request->getVar('ids');
            
            $affectedRows = $this->MSModel->deleteMultipleData($ids);
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

    public function get($id)
    {
        $data = $this->MSModel->getOne($id);
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $data
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    protected function buildCustomButtonActions($id)
    {
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-primary btn-xs mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye mr-1\"></i>Detail</button>
                    <button type=\"button\" class=\"btn btn-info btn-xs mr-2\" data-item-id=\"$id\"><i class=\"fas fa-pencil-alt mr-1\"></i>Edit</button>
                    <button type=\"button\" class=\"btn btn-danger btn-xs\" data-item-id=\"$id\"><i class=\"fas fa-trash mr-1\"></i>Hapus</button>
                </div>";
    }
}
