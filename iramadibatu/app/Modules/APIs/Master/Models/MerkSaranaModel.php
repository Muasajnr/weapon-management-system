<?php

namespace App\Modules\APIs\Master\Models;

use App\Core\CoreApiModel;

class MerkSaranaModel extends CoreApiModel
{
    // Datatables
    protected $columnOrder          = [null, null, 'name', 'desc', 'is_active', 'created_at', null];
    protected $columnSearch         = ['name'];

    public function __construct()
    {
        parent::__construct('merk_sarana');
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
}
