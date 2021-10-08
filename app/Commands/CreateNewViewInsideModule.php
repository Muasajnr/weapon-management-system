<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class CreateNewViewInsideModule extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Modules';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'make:module:view';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Create a new view inside a module.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:module:view <module_name> <view_name>';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'module_name'   => 'The module name that we want to store the view.',
        'view_name'     => 'The view name.',
    ];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        try {
            if (empty($params)) throw new Exception('No argument specified.');
            
            $moduleName = $params[0];
            $viewName = $params[1];
            $baseModulePath = ROOTPATH.'app/Modules/'.$moduleName;

            if (!is_dir($baseModulePath)) throw new Exception('Module not found!');

            $viewFile = ROOTPATH.'app/Modules/'.$moduleName.'/Views/'.$viewName.'.php';
            if (file_exists($viewFile)) throw new Exception('View already exist!');

            fopen($viewFile, 'w');

            CLI::write(CLI::color('View created.', 'blue'));
        } catch (Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
        }
    }
}
