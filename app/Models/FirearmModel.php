<?php

namespace App\Models;

use App\Core\MyModel;

class FirearmModel extends MyModel
{

    protected $table                = 'firearms';
    protected $returnType           = 'App\Entities\FirearmEntity';
    protected $allowedFields        = [
        'inventory_type_id', 
        'firearms_type_id', 
        'firearms_brand_id', 
        'firearms_number', 
        'bpsa_number', 
        'condition', 
        'description', 
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    // Datatables
    protected $columnOrder          = [
        null, 
        null, 
        'inventory_type_id', 
        'firearms_type_id', 
        'firearms_brand_id',
        'firearms_number',
        'bpsa_number',
        'condition',
        null
    ];
    protected $columnSearch         = [
        'inventory_type_id', 
        'firearms_type_id', 
        'firearms_brand_id',
        'firearms_number',
        'bpsa_number',
        'condition',
    ];


    public function __construct()
    {
        parent::__construct();
    }

    public function getDatatables(string $searchQuery, int $start, int $length, array $order) {
        $i = 0;
        
        $this->builder()->select(
            'firearms.bpsa_number as bpsa_number,
            firearms.firearms_number as firearm_number,
            firearms.condition as condition, 
            firearms.description as description,
            inventory_types.name as inventory_type, 
            firearms_types.name as firearm_type, 
            firearms_brands.name as firearm_brand,
            firearms.id as firearm_id'
        );
        $this->builder()->join('inventory_types', 'inventory_types.id = firearms.inventory_type_id', 'left');
        $this->builder()->join('firearms_types', 'firearms_types.id = firearms.firearms_type_id', 'left');
        $this->builder()->join('firearms_brands', 'firearms_brands.id = firearms.firearms_brand_id', 'left');

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

        $this->builder()->where('firearms.deleted_at', null);

        $result = $this->builder()->get();
        return $result->getResult();
    }

    /** datatables for stocks */
    public function getDatatablesForStok(string $searchQuery, int $start, int $length, array $order)
    {
        $i = 0;
        $stockStatusSql = 'IF(count(firearms.firearms_type_id)<10, "sedikit", IF(count(firearms.firearms_type_id)<50, "lumayan", IF(count(firearms.firearms_type_id)<100, "banyak", "unknown")))';
        $countStockSql = 'count(firearms.firearms_type_id)';
        $this->builder()->select(
            "
            firearms_types.id as firearms_types_id,
            firearms_types.name as firearms_types_name,
            $countStockSql as stock,
            count(borrowings.firearm_id) as borrowed_count,
            $stockStatusSql as stock_status
            "
        );
        $this->builder()->join('firearms_types', 'firearms_types.id = firearms.firearms_type_id', 'left');
        $this->builder()->join('borrowings', 'borrowings.firearm_id = firearms.id', 'left');

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

        $this->builder()->where('firearms.deleted_at', null);
        $this->builder()->groupBy('firearms.firearms_type_id');

        $result = $this->builder()->get();
        return $result->getResult();
    }

    public function getTotalRecordsForStock(string $searchQuery, array $order)
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
        $this->builder()->groupBy('firearms.firearms_type_id');

        return $this->builder()->countAllResults();
    }

    public function getTotalFilteredRecordsForStock()
    {
        $this->builder()->where('deleted_at', null);
        $this->builder()->groupBy('firearms.firearms_type_id');
        return $this->builder()->countAllResults();
    }

}
