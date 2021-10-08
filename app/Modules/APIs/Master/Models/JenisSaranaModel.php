<?php

namespace App\Modules\APIs\Master\Models;

use CodeIgniter\Model;

class JenisSaranaModel extends Model
{
    // Datatables
    protected $columnOrder          = [null, null, 'name', 'desc', 'is_active', 'created_at', null];
    protected $columnSearch         = ['name'];

    private $JIBuilder;

    public function __construct()
    {
        parent::__construct();
        $this->JIBuilder = $this->builder('jenis_sarana');
    }

    public function getDatatables(string $searchQuery, int $start, int $length, array $order) {
        $i = 0;

        foreach($this->columnSearch as $column) {
            if ($searchQuery) {
                if ($i === 0) {
                    $this->JIBuilder->groupStart();
                    $this->JIBuilder->like($column, $searchQuery);
                } else {
                    $this->JIBuilder->orLike($column, $searchQuery);
                }

                if (count($this->columnSearch) - 1 === $i)
                    $this->JIBuilder->groupEnd();
            }
            $i++;
        }

        if ($order)
            $this->JIBuilder->orderBy($this->columnOrder[$order['0']['column']], $order['0']['dir']);

        if ($length !== -1)
            $this->JIBuilder->limit($length, $start);

        $this->JIBuilder->where('deleted_at', null);

        $result = $this->JIBuilder->get();
        return $result->getResult();
    }

    public function getTotalRecords(string $searchQuery, array $order)
    {
        $i = 0;
        foreach($this->columnSearch as $column) {
            if ($searchQuery) {
                if ($i === 0) {
                    $this->JIBuilder->groupStart();
                    $this->JIBuilder->like($column, $searchQuery);
                } else {
                    $this->JIBuilder->orLike($column, $searchQuery);
                }

                if (count($this->columnSearch) - 1 === $i)
                    $this->JIBuilder->groupEnd();
            }
            $i++;
        }

        if ($order)
            $this->JIBuilder->orderBy($this->columnOrder[$order['0']['column']], $order['0']['dir']);

        $this->JIBuilder->where('deleted_at', null);

        return $this->JIBuilder->countAllResults();
    }

    public function getTotalFilteredRecords()
    {
        $this->JIBuilder->where('deleted_at', null);
        return $this->JIBuilder->countAllResults();
    }
}
