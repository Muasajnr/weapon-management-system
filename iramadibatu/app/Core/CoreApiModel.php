<?php

namespace App\Core;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class CoreApiModel extends Model
{

    private $builders;

    private $defaultBuilder = '';

    protected $columnOrder          = [];
    protected $columnSearch         = [];

    protected $authenticatedUser;

    
    public function __construct(string $builderName = '')
    {
        parent::__construct();

        if (!empty($builderName)) {
            $this->defaultBuilder = $builderName;
            $this->builders[$builderName] = $this->builder($builderName);
        }
    }

    protected function setDefaultBuilder(string $builderName)
    {
        $this->defaultBuilder = $builderName;
    }

    protected function defaultBuilder() : BaseBuilder
    {
        return $this->builders[$this->defaultBuilder];
    }
    
    protected function addBuilder(string $builderName)
    {
        $this->builders[$builderName] = $this->builder($builderName);
    }

    protected function getBuilder(string $builderName)
    {
        return $this->builders[$builderName];
    }

    public function setAuthenticatedUser(string $username)
    {
        $this->authenticatedUser = $username;
    }

    /**
     * get all datatables data
     * 
     * @param array $dtParams
     * @param history $bool
     * @param string $customBuilder
     * 
     * @return array
     */
    public function datatable(array $dtParams, bool $history = false) : array {
        $i = 0;

        foreach($this->columnSearch as $column) {
            if (isset($dtParams['search']) && !empty($dtParams['search'])) {
                if ($i === 0) {
                    $this->defaultBuilder()->groupStart();
                    $this->defaultBuilder()->like($column, $dtParams['search']['value']);
                } else {
                    $this->defaultBuilder()->orLike($column, $dtParams['search']['value']);
                }

                if (count($this->columnSearch) - 1 === $i)
                $this->defaultBuilder()->groupEnd();
            }
            $i++;
        }

        if (isset($dtParams['order']))
            $this->defaultBuilder()->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1)
                $this->defaultBuilder()->limit($dtParams['length'], $dtParams['start']);
        }

        if (!$history)
            $this->defaultBuilder()->where('deleted_at', null);
        else
            $this->defaultBuilder()->where('deleted_at is not null');
        
        $result = $this->defaultBuilder()->get();
        return $result->getResultArray();
    }

    /**
     * count datatable records
     * 
     * @param array $dtParams
     * @param bool $history
     * @param string $customBuilder
     * 
     * @return int
     */
    public function countDatatableData(array $dtParams, bool $history = false) : int
    {
        $i = 0;
        foreach($this->columnSearch as $column) {
            if (isset($dtParams['search']) && !empty($dtParams['search'])) {
                if ($i === 0) {
                    $this->defaultBuilder()->groupStart();
                    $this->defaultBuilder()->like($column, $dtParams['search']['value']);
                } else {
                    $this->defaultBuilder()->orLike($column, $dtParams['search']['value']);
                }

                if (count($this->columnSearch) - 1 === $i)
                    $this->defaultBuilder()->groupEnd();
            }
            $i++;
        }

        if (isset($dtParams['order']))
            $this->defaultBuilder()->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);

            if (!$history)
                $this->defaultBuilder()->where('deleted_at', null);
            else
                $this->defaultBuilder()->where('deleted_at is not null');

        return $this->defaultBuilder()->countAllResults();
    }

    /**
     * get total of filtered records of datatables
     * 
     * @param bool $history
     * @param string $customBuilder
     * 
     * @return int
     */
    public function countDatatableFilteredData(bool $history = false)
    {
        if (!$history)
            $this->defaultBuilder()->where('deleted_at', null);
        else
            $this->defaultBuilder()->where('deleted_at is not null');
        
        return $this->defaultBuilder()->countAllResults();
    }

    /**
     * get all data
     * 
     * @param bool $history
     * 
     * @return array
     */
    public function getAll($history = false) : array
    {
        $this->defaultBuilder()->select('*');
        if (!$history)
            $this->defaultBuilder()->where('deleted_at', null);
        else
            $this->defaultBuilder()->where('deleted_at is not null');

        return $this->defaultBuilder()
                    ->get()
                    ->getResultArray();
    }

    /**
     * get one data by id
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getOne($id) : ?array
    {
        $this->defaultBuilder()->select('*');
        $this->defaultBuilder()->where('id', $id);
        $this->defaultBuilder()->where('deleted_at', null);

        return $this->defaultBuilder()
                    ->get()
                    ->getRowArray();
    }

    public function isExist($id) : bool
    {
        $result = $this->defaultBuilder()
            ->selectCount('*', 'count')
            ->where('id', $id)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();
        return $result['count'] > 0;
    }

    /********************************* start create *********************************/

    /**
     * create a new data
     * 
     * @param array $data
     * @param bool $getId
     * 
     * @return bool
     */
    public function createData(array $data, bool $getId = false)
    {
        $now = Time::now();
        $data['created_at']         = $now->toDateTimeString();
        $data['sys_created_user']   = $this->authenticatedUser;
        $data['updated_at']         = $now->toDateTimeString();
        $data['sys_updated_user']   = $this->authenticatedUser;
        
        $result = $this->defaultBuilder()->insert($data);
        return $getId ? $this->db->insertID() : $result;
    }

    /**
     * create multiple data
     * 
     * @param array $data
     * 
     * @return int|bool
     */
    public function createBatch(array $data)
    {
        $now = Time::now();

        foreach($data as &$item) {
            $item['created_at']         = $now->toDateTimeString();
            $item['sys_created_user']   = $this->authenticatedUser;
            $item['updated_at']         = $now->toDateTimeString();
            $item['sys_updated_user']   = $this->authenticatedUser;
        }

        return $this->defaultBuilder()
                    ->insertBatch($data);
    }

    /********************************* end create *********************************/

    /********************************* start update *********************************/

    /**
     * edit jenis datatable
     * 
     * @param int $id
     * @param array $data
     * 
     * @return bool
     */
    public function updateData(int $id, array $data) : bool
    {
        $now = Time::now();
        $this->defaultBuilder()->set('updated_at', $now->toDateTimeString());
        $this->defaultBuilder()->set('sys_updated_user', $this->authenticatedUser);
        $this->defaultBuilder()->set($data);
        $this->defaultBuilder()->where('id', $id);
        return $this->defaultBuilder()
                    ->update();
    }

    /**
     * soft delete jenis datatable
     * 
     * @param int id
     * 
     * @return bool
     */
    public function deleteData(int $id) : bool
    {
        $now = Time::now();
        $this->defaultBuilder()->set('deleted_at', $now->toDateTimeString());
        $this->defaultBuilder()->set('sys_deleted_user', $this->authenticatedUser);
        $this->defaultBuilder()->where('id', $id);
        return $this->defaultBuilder()
                    ->update();
    }

    /** 
     * multiple soft delete jenis datatable
     * 
     * @param array $ids
     * 
     * @return bool
     */
    public function deleteMultipleData(array $ids)
    {
        $softDeleteData = [];
        $now = Time::now();
        for($i = 0; $i < count($ids); $i++) {
            array_push($softDeleteData, [
                'id'    => $ids[$i],
                'deleted_at'    => $now->toDateTimeString(),
                'sys_deleted_user'  => $this->authenticatedUser,
            ]);
        }
        return $this->defaultBuilder()
                    ->updateBatch($softDeleteData, 'id');
    }

    /**
     * restore data
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function restoreData(int $id) {}

    /**
     * restore multiple data
     * 
     * @param array $ids
     * 
     * @return bool
     */
    public function restoreBatch(array $ids) {}

    /********************************* end update *********************************/

    /********************************* start delete *********************************/

    /**
     * purge data
     *  
     * @param int $id
     * 
     * @return bool
     */
    public function purgeData(int $id) {}

    /**
     * purge multiple data
     * 
     * @param array $ids
     */
    public function purgeBatch(array $ids) {}

    /********************************* end delete *********************************/
}
