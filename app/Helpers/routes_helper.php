<?php

// function loadModulesRoute() {
    // $uri = service('uri');
    // $firstSegment = ucfirst(strtolower($uri->getSegment(1)));
    // if ($firstSegment == 'api')
    //     $module = ucfirst(strtolower($uri->getSegment()));

    // if (empty($module))
    //     require_once(ROOTPATH.'app/Modules/Home/Routes.php');
    // else {

    //     require_once(ROOTPATH.'app/Modules/' . $module. '/Routes.php');
    // }
// }

function loadModulesRoutes(string $modulePath) : array {
    $dir = scandir($modulePath);

    $scannedRoutes = [];

    foreach($dir as $module) {
        if ($module == '.' || $module == '..') continue;

        $moduleFiles = scandir($modulePath.$module);
        if (in_array('Routes.php', $moduleFiles)) {
            array_push($scannedRoutes, $modulePath.$module.'/Routes.php');
        } else {
            $subScannedRoutes = loadModulesRoutes($modulePath.$module.'/');
            $scannedRoutes = array_merge($scannedRoutes, $subScannedRoutes);
        }
    }

    return $scannedRoutes;
}