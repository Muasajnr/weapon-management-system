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

}
