<?php

namespace App\Models;

use App\Core\MyModel;
use CodeIgniter\I18n\Time;

class InventoryTypeModel extends MyModel
{
    protected $table                = 'inventory_types';
    protected $returnType           = 'App\Entities\InventoryTypeEntity';
    protected $allowedFields        = ['name', 'desc', 'is_active', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder  = [null, 'name', 'desc', 'is_active', 'created_at', null];
    protected $columnSearch = ['name'];


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ********************* get *********************************
     */
    public function getOne(int $id): ?object
    {
        $this->builder()->select('*');
        $this->builder()->where('id', $id);
        $this->builder()->where('deleted_at', null);
        $this->builder()->limit(1);
        return $this->builder()->get()->getRow();
    }

    public function getDatatables(string $searchQuery, int $start, int $length, array $order) {
        $i = 0;
        foreach($this->columnSearch as $column) {
            if ($searchQuery) {
                if ($i === 0) {
                    $this->builder()->groupStart();
                    $this->builder()->like($column, $searchQuery);
                } else {
                    $this->builder()->orLike($column, $searchQuery);
                }

                if (count($this->columnSearch) - 1 === $i)
                    $this->builder()->groupEnd();
            }
            $i++;
        }

        if ($order)
            $this->builder()->orderBy($this->columnOrder[$order['0']['column']], $order['0']['dir']);

        if ($length !== -1)
            $this->builder()->limit($length, $start);

        $this->builder()->where('deleted_at', null);

        $result = $this->builder()->get();
        return $result->getResult();
    }

    public function getTotalRecords(string $searchQuery, array $order)
    {
        $i = 0;
        foreach($this->columnSearch as $column) {
            if ($searchQuery) {
                if ($i === 0) {
                    $this->builder()->groupStart();
                    $this->builder()->like($column, $searchQuery);
                } else {
                    $this->builder()->orLike($column, $searchQuery);
                }

                if (count($this->columnSearch) - 1 === $i)
                    $this->builder()->groupEnd();
            }
            $i++;
        }

        if ($order)
            $this->builder()->orderBy($this->columnOrder[$order['0']['column']], $order['0']['dir']);

        $this->builder()->where('deleted_at', null);

        return $this->builder()->countAllResults();
    }

    public function getTotalFilteredRecords()
    {
        $this->builder()->where('deleted_at', null);
        return $this->builder()->countAllResults();
    }

    /**
     * ********************* checking *********************************
     */
    public function isExist(int $id) : bool {
        $this->builder()->select('count(*) as count');
        $this->builder()->where('id', $id);
        $this->builder()->limit(1);
        return $this->builder()->get()->getRow()->count > 0 ? true : false;
    }

    /**
     * ********************* insert *********************************
     */
    public function createNew(array $data) {
        $timeNow = Time::now();
        $data['created_at'] = $timeNow->toDateTimeString();
        $data['updated_at'] = $timeNow->toDateTimeString();
        $data['deleted_at'] = null;

        $this->insert($data);

        return $this->db->affectedRows() > 0 ? true : false;
    }

    /**
     * ********************* update *********************************
     */
    public function updateStatus(int $id, bool $isActive) : bool
    {
        $this->where('id', $id)
            ->set(['is_active' => $isActive])
            ->update();

        return $this->db->affectedRows() > 0 ? true : false;
    }

    public function updateData(int $id, array $data) : bool
    {
        $this->where('id', $id)
            ->set($data)
            ->update();

        return $this->db->affectedRows() > 0 ? true : false;
    }

    /**
     * ********************* delete *********************************
     */
    public function deleteData(int $id): bool
    {
        $this->delete($id);

        return $this->db->affectedRows() > 0 ? true : false;
    }

    public function deleteMultipleData(array $ids) : int {
        $this->delete($ids);

        return $this->db->affectedRows();
    }
}
