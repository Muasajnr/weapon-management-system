<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateNewEntityInsideModule extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'ModulesGenerator';

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
    protected $usage = 'make:module:entity [ModuleName] [Entity]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

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
        $moduleName = $params[0];
        $entityName = $params[1];
        $baseModulePath = ROOTPATH.'app/Modules/'.$moduleName;

        try {
            if (!is_dir($baseModulePath)) throw new \Exception('Module not found!');

            $this->call('make:entity', ['App/Modules/'.$moduleName.'/Entities//'.$entityName]);
        } catch (\Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
        }
    }
}
