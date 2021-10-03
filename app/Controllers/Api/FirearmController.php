<?php

namespace App\Controllers\Api;

use App\Core\ApiController;
use App\Models\FirearmModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class FirearmController extends ApiController
{
    public function index()
    {
        //
    }

    /******************** datatable **********************/
    public function datatables()
    {
        $draw               = $this->request->getPost('draw');
        $searchQuery        = $this->request->getPost('search');
        $length             = $this->request->getPost('length');
        $start              = $this->request->getPost('start');
        $order              = $this->request->getPost('order') ?? [];

        $resData            = [];

        $firearmModel       = new FirearmModel();
        $data               = $firearmModel->getDatatables($searchQuery['value'], $start, $length, $order);
        $recordsTotal       = $firearmModel->getTotalRecords($searchQuery['value'], $order);
        $recordsFiltered    = $firearmModel->getTotalFilteredRecords();

        $num = $start;
        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"$item->firearm_id\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"$item->firearm_id\">{$num}.";
            $row[]      = "{$item->inventory_type}";
            $row[]      = "{$item->firearm_type}";
            $row[]      = "{$item->firearm_brand}";
            $row[]      = "{$item->firearm_number}";
            $row[]      = "{$item->bpsa_number}";
            $row[]      = $this->buildDatatableConditionRow($item->condition);
            $row[]      = $this->buildDatatableStatusRow($item->is_borrowed);
            $row[]      = $this->buildCustomActionsButtons($item->firearm_id);

            $resData[] = $row;
        }

        $output = [
            'draw'  => $draw,
            'recordsTotal'  => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'  => $resData,
        ];

        return $this->respond($output, ResponseInterface::HTTP_OK);
    }

    /******************** insert **********************/
    public function create()
    {
        if (!$this->request->isAJAX())
            return $this->fail('Invalid request!');
        
        $rules      = [
            'inventory_type_id'     => 'required',
            'firearms_type_id'      => 'required',
            'firearms_brand_id'     => 'required',
            'firearms_number'       => 'required',
            'bpsa_number'           => 'required',
            'condition'             => 'required',
            'description'           => 'required'
        ];
        $messages   = [
            'inventory_type_id'     => ['required' => 'inventory_type is required'],
            'firearms_type_id'      => ['required' => 'firearm_type is required'],
            'firearms_brand_id'     => ['required' => 'firearm_brand is required'],
            'firearms_number'       => ['required' => 'firearm_number is required'],
            'bpsa_number'           => ['required' => 'bpsa_number is required'],
            'condition'             => ['required' => 'condition is required'],
            'description'           => ['required' => 'desc is required'],
        ];

        if (!$this->validate($rules, $messages))
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
        
        $data = $this->request->getVar();
        $firearmModel = new FirearmModel();
        $isAdded = $firearmModel->createNew((array) $data);
        if (!$isAdded) {
            return $this->fail('Something went wrong!');
        } else {
            return $this->respondCreated([
                'status'    => ResponseInterface::HTTP_CREATED,
                'message'   => 'Data telah ditambahkan!'
            ]);
        }
    }

    /******************** update **********************/
    public function update($id)
    {
        if (!$this->request->isAJAX())
            return $this->fail('Invalid request!');
        
        $rules      = [
            'inventory_type_id'     => 'required',
            'firearms_type_id'      => 'required',
            'firearms_brand_id'     => 'required',
            'firearms_number'       => 'required',
            'bpsa_number'           => 'required',
            'condition'             => 'required',
            'description'           => 'required'
        ];
        $messages   = [
            'inventory_type_id'     => ['required' => 'inventory_type is required'],
            'firearms_type_id'      => ['required' => 'firearm_type is required'],
            'firearms_brand_id'     => ['required' => 'firearm_brand is required'],
            'firearms_number'       => ['required' => 'firearm_number is required'],
            'bpsa_number'           => ['required' => 'bpsa_number is required'],
            'condition'             => ['required' => 'condition is required'],
            'description'           => ['required' => 'desc is required'],
        ];

        if (!$this->validate($rules, $messages))
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');
        
        $firearmModel = new FirearmModel();
        $data = $firearmModel->getOne((int)$id);

        if (!$data)
            return $this->failNotFound();
        
        $reqData = $this->request->getVar();
        $reqData->updated_at = Time::now()->toDateTimeString();
        $isUpdated = $firearmModel->updateData((int)$id, (array) $reqData);
        if (!$isUpdated)
            return $this->fail('Something went wrong!');
        
        return $this->respondUpdated([
            'status'    => ResponseInterface::HTTP_OK,
            'message'   => 'Data telah diupdate!'
        ]);
    }

    /******************** delete **********************/
    public function delete($id)
    {
        $firearmModel = new FirearmModel();
        if (!$firearmModel->isExist((int) $id))
            return $this->failNotFound('Not found!');
        
        $isDeleted = $firearmModel->deleteData($id);
        if (!$isDeleted)
            return $this->fail('Failed to delete! please contact your administrator.');
        
        return $this->respondDeleted([
            'success'   => ResponseInterface::HTTP_OK,
            'message'   => 'Data telah dihapus!'
        ]);
    }

    public function deleteMultiple()
    {
        if (!$this->request->isAJAX())
            return $this->fail('Invalid request!');
        
        $rules      = ['ids' => 'required'];
        $messages   = [
            'ids' => ['required' => 'ids is required']
        ];
        
        if (!$this->validate($rules, $messages))
            return $this->failValidationErrors($this->validator->getErrors(), 'validation failed!');

        $ids = $this->request->getVar('ids');
        
        $firearmModel = new FirearmModel();
        $affectedRows = $firearmModel->deleteMultipleData($ids);
        if ($affectedRows != count($ids))
            return $this->fail('Only some data gets deleted! please contact your administrator.');
        
        return $this->respondDeleted([
            'success'   => ResponseInterface::HTTP_OK,
            'message'   => 'Data yang dipilih telah terhapus!'
        ]);
    }

    /******************* helper method *********************** */
    private function buildDatatableConditionRow(string $condition) : string
    {
        switch($condition):
            case 'normal':
                return "<div class=\"text-center\"><span class=\"badge badge-success\">normal</span></div>";
            case 'damaged':
                return "<div class=\"text-center\"><span class=\"badge badge-danger\">rusak</span></div>";
            default:
                return "<div class=\"text-center\"><span class=\"badge badge-info\">undefined</span></div>";
        endswitch;
    }

    private function buildDatatableStatusRow(string $isBorrowed) : string
    {
        return $isBorrowed == '1' ? "<span class=\"badge badge-warning\">dipinjam</span" : "<span class=\"badge badge-success\">tersedia</span";
    }

    private function buildCustomActionsButtons($id)
    {
        $editUrl = site_url('/dashboard/senjata-api/'.$id.'/edit');
        return "<div class=\"text-center\">
                    <button type=\"button\" class=\"btn btn-primary btn-sm mr-2\" data-item-id=\"$id\"><i class=\"fas fa-eye\"></i></button>
                    <a href=\"$editUrl\" type=\"button\" class=\"btn btn-info btn-sm mr-2\"><i class=\"fas fa-pencil-alt\"></i></a>
                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-item-id=\"$id\"><i class=\"fas fa-trash\"></i></button>
                </div>";
    }
}
