<?php

namespace App\Core;

use App\Controllers\BaseController;

class WebController extends BaseController
{

    protected function renderView(string $viewName, array $data = [])
    {
        $uri = service('uri');
        $moduleName = ucfirst(strtolower($uri->getSegment(1)));

        if (empty($moduleName)) {
            $data['moduleViewPath'] = '\App\Modules\Home\Views\\';
            return view('\App\Modules\Home\Views\\'.$viewName);
        }

        $data['moduleViewPath'] = '\App\Modules\\'.$moduleName.'\Views\\';
        return view('\App\Modules\\'.$moduleName.'\Views\\'.$viewName, $data);
        
    }
}
