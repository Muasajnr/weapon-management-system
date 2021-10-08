<?php

namespace App\Core;

use App\Controllers\BaseController;

class WebController extends BaseController
{

    protected $currPath;

    public function __construct(string $currPath)
    {   
        $this->currPath = $currPath;
    }

    // protected function renderView(string $viewName, array $data = [])
    // {
    //     $uri = service('uri');
    //     $moduleName = ucfirst(strtolower($uri->getSegment(1)));

    //     if (empty($moduleName)) {
    //         $data['moduleViewPath'] = '\App\Modules\Home\Views\\';
    //         return view('\App\Modules\Home\Views\\'.$viewName);
    //     }

    //     $data['moduleViewPath'] = '\App\Modules\\'.$moduleName.'\Views\\';
    //     return view('\App\Modules\\'.$moduleName.'\Views\\'.$viewName, $data);
    // }
    protected function renderView(string $viewName, array $data = [])
    {
        $filePath = $this->currPath;
        $arrPath = explode('\\', '\App\\'.strstr($filePath, 'Modules'));

        array_pop($arrPath);
        array_push($arrPath, 'Views');

        $data['moduleViewPath'] = implode('\\', $arrPath) . '\\';

        return view($data['moduleViewPath'].$viewName, $data);
    }
}
