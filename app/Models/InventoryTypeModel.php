<?php

namespace App\Models;

use App\Core\MyModel;

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

        return $this->builder()->countAllResults();
    }

    public function getTotalFilteredRecords()
    {
        return $this->builder()->countAllResults();
    }
}
