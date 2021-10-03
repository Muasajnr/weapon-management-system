<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Core\ApiController;
use App\Models\FirearmModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends ApiController
{
    public function cardsData()
    {
        $firearm_model = new FirearmModel();
        $user_model = new UserModel();

        $firearm_total = $firearm_model->getFirearmsTotal();
        $borrowed_firearms_total = $firearm_model->getBorrowedFirearmsTotal();
        $firearm_returneds_total = $firearm_model->getReturnedFirearmsTotal();
        $user_total = $user_model->getTotalUser();

        return $this->respond([
            'status'    => ResponseInterface::HTTP_OK,
            'data'      => [
                'firearm_total'             => $firearm_total,
                'borrowed_firearm_total'    => $borrowed_firearms_total,
                'returned_firearm_total'    => $firearm_returneds_total,
                'user_total'                => $user_total
            ]
        ], ResponseInterface::HTTP_OK);
    }

    public function stockByInventoryType()
    {
        $firearm_model = new FirearmModel();
        $data = $firearm_model->getChartDataByInventoryTypes();
    }

    public function stockByFirearmType()
    {

    }

    public function stockByFirearmBrand()
    {

    }

    public function top10Firearm()
    {

    }

    public function top10BorrowedFirearm()
    {

    }
}
