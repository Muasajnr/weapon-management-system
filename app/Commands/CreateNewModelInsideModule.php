<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class CreateNewModelInsideModule extends BaseCommand
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
    protected $name = 'make:module:model';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Create a new model inside a module.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:module:model [module_name] [model_name]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'module_name'   => 'Module to store the model.',
        'model_name'   => 'The model name.',
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
            $modelName = $params[1];
            $baseModulePath = ROOTPATH.'app/Modules/'.$moduleName;

            if (!is_dir($baseModulePath)) throw new Exception('Module not found!');

            $this->call('make:model', ['App/Modules/'.$moduleName.'/Models/'.$modelName]);
        } catch (Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
        }
    }
}
