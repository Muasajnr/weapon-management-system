<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class CreateNewEntityInsideModule extends BaseCommand
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
    protected $name = 'make:module:entity';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Create a new entity inside a module.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:module:entity <module_name> <entity_name>';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'module_name'   => 'The module name to store the entity.',
        'entity_name'   => 'Entity name.',
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
            $entityName = $params[1];
            $baseModulePath = ROOTPATH.'app/Modules/'.$moduleName;

            if (!is_dir($baseModulePath)) throw new Exception('Module not found!');

            $this->call('make:entity', ['App/Modules/'.$moduleName.'/Entities/'.$entityName]);
        } catch (Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
        }
    }
}
