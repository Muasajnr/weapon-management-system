<?php

namespace App\Core;

use App\Controllers\BaseController;

class WebController extends BaseController
{

    protected $currPath;

    protected $contentIncludes = [];

    public function __construct(string $currPath)
    {   
        $this->currPath = $currPath;
    }

    protected function renderView(string $viewName, array $data = [])
    {
        $filePath = $this->currPath;
        $paths = explode('/', $filePath);
        $arrPath = '';
        
        // if linux
        if (count($paths) > 1) {
            $arrPath = explode('/', '/App//'.strstr($filePath, 'Modules'));
        } else {
            $arrPath = explode('\\', '\App\\'.strstr($filePath, 'Modules'));
        }

        array_pop($arrPath);
        array_push($arrPath, 'Views');

        $data['moduleViewPath'] = implode('\\', $arrPath) . '\\';
        $data['contentIncludeData'] = $this->contentIncludes;
        $data['userLevel'] = session('userdata')['level'] ?? '';
        $data['loggedUsername'] = session('userdata')['username'] ?? '';
        
        return view($data['moduleViewPath'].$viewName, $data);
    }
}
