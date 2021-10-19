<?php

namespace App\Modules\APIs\Master\Models;

use App\Core\CoreApiModel;
use CodeIgniter\Model;

class JenisSaranaModel extends CoreApiModel
{
    // Datatables
    protected $columnOrder          = [null, null, 'name', 'desc', 'is_active', 'created_at', null];
    protected $columnSearch         = ['name'];


    public function __construct()
    {
        parent::__construct('jenis_sarana');
    }

    /**
     * set jenis datatable to in-active
     * 
     * @param int $id
     * @param int $isActive
     * 
     * @return bool
     */
    public function setActive(int $id, int $isActive) : bool
    {
        return $this->defaultBuilder()
            ->set('is_active', $isActive)
            ->where('id', $id)
            ->update();
    }

    public function checkByName(string $name)
    {
        $this->defaultBuilder()->select('id, name');
        $this->defaultBuilder()->where('name', $name);
        return $this->defaultBuilder()->get()->getRowArray();
    }

}
