<?php

namespace App\Modules\APIs\Users\Controllers;

use App\Core\ApiController;
use App\Modules\APIs\Users\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends ApiController
{

    private $userModel;

    
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        //
    }

    public function datatables()
    {
        $posts = $this->request->getPost();
        $data = $this->userModel->datatable($posts);
        $num = $posts['start'];
        $resData = [];

        foreach($data as $item) {
            $num++;

            $row        = [];
            $row[]      = "<div class=\"text-center\"><input class=\"multi_delete\" type=\"checkbox\" name=\"multi_delete[]\" data-item-id=\"".$item['id']."\"></div>";
            $row[]      = "<input type=\"hidden\" value=\"".$item['id']."\">{$num}.";
            $row[]      = $item['fullname'];
            $row[]      = $item['username'];
            $row[]      = $item['email'];
            $row[]      = $item['level'];
            $row[]      = $item['last_login'];
            $row[]      = $item['created_at'];
            $row[]      = $this->buildActionButtons($item['id']);

            $resData[] = $row;
        }

        $output['draw']             = $posts['draw'];
        $output['recordsTotal']     = $this->userModel->countDatatableData($posts);
        $output['recordsFiltered']  = $this->userModel->countDatatableFilteredData();
        $output['data']             = $resData;

        return $this->response
            ->setJSON($output)
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
