<?php

namespace App\Modules\APIs\Master\Controllers;

use App\Core\ApiController;
use App\Exceptions\ApiAccessErrorException;
use App\Modules\APIs\Master\Models\JenisInventarisModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class JenisInventarisController extends ApiController
{
    private $JIModel;

    public function __construct()
    {
        parent::__construct();
        $this->JIModel = new JenisInventarisModel();
    }

    public function index()
    {
        $allData = $this->JIModel->getAll();
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $allData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function get($id)
    {
        $data = $this->JIModel->getOne($id);
        return $this->response
            ->setJSON([
                'status'    => ResponseInterface::HTTP_OK,
                'data'      => $data
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    /**datatables */
    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->JIModel->datatable($posts);
        $num = $posts['start'];
        $resData = [];

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
        $output['recordsTotal']     = $this->JIModel->countDatatableData($posts);
        $output['recordsFiltered']  = $this->JIModel->countDatatableFilteredData();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    /**datatables history */
    public function datatablesHistory() {}

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

            $this->JIModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $newData['name'] = $data['name'];
            $newData['desc'] = $data['desc'];
            $newData['is_active'] = $data['is_active'];

            $isAdded = $this->JIModel->createData($newData);
            
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
            
            $rules = ['name' => 'required', 'desc' => 'required', 'is_active' => 'required'];

            if (!$this->validate($rules))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            if(!$this->JIModel->isExist($id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND
                );

            $this->JIModel->setAuthenticatedUser(
                $this->request
                    ->header('Logged-User')
                    ->getValue()
            );

            $data = $this->request->getVar();

            $updatedData['name'] = $data['name'];
            $updatedData['desc'] = $data['desc'];
            $updatedData['is_active'] = $data['is_active'];

            $isUpdated = $this->JIModel->updateData($id, $updatedData);
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
            $messages   = ['is_active' => ['required' => 'is_active is required']];
    
            if (!$this->validate($rules, $messages))
                throw new ApiAccessErrorException(
                    'Validation Error!', 
                    ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                    $this->validator->getErrors()
                );
            
            if(!$this->JIModel->isExist($id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );
            
            $isActive = $this->request->getVar('is_active');
            $isUpdated = $this->JIModel->setActive($id, $isActive);
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

    /**delete */
    public function delete($id)
    {
        try {
            if (!$this->JIModel->isExist((int) $id))
                throw new ApiAccessErrorException(
                    'Not Found!', 
                    ResponseInterface::HTTP_NOT_FOUND,
                    $this->validator->getErrors()
                );

            $isDeleted = $this->JIModel->deleteData($id);
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
            
            $affectedRows = $this->JIModel->deleteMultipleData($ids);
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

    /**restore */
    public function restore($id)
    {

    }

    /**restore multiple */

    /**purge */
    public function purge($id)
    {

    }

    /**purge multiple */
    public function purgeMultiple($id)
    {

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
