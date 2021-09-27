<?php

namespace App\Models;

use App\Core\MyModel;

class BorrowingModel extends MyModel
{
    protected $table                = 'borrowings';
    protected $returnType           = 'App\Entities\BorrowingEntity';
    protected $allowedFields        = ['firearm_id', 'document_id', 'desc', 'created_at', 'updated_at', 'deleted_at'];

    // Datatables
    protected $columnOrder          = [];
    protected $columnSearch         = [];


    public function __construct()
    {
        parent::__construct();
    }

    public function getDatatables(string $searchQuery, int $start, int $length, array $order) {
        $i = 0;
        
        $this->builder()->select(
            '
            firearms_types.name as firearm_type, 

            firearms_brands.name as firearm_brand,

            firearms.bpsa_number as bpsa_number,
            firearms.firearms_number as firearm_number,

            borrowings.id as id,
            borrowings.desc as desc,
            borrowings.created_at as created_at
            '
        );

        $this->builder()->join('firearms', 'firearms.id = borrowings.firearm_id', 'left');
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

        $this->builder()->where('borrowings.deleted_at', null);

        $result = $this->builder()->get();
        return $result->getResult();
    }
}
