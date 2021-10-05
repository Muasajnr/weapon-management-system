<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class CreateNewModule extends BaseCommand
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
    protected $name = 'make:module';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:module [ModuleName]';

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

        $baseModulePath = ROOTPATH.'app/Modules/'.$moduleName;

        try {
            if (is_dir($baseModulePath)) throw new Exception('Module already exist!');

            if (!is_dir($baseModulePath.'/Controllers')) mkdir($baseModulePath.'/Controllers', 0777, true);
            if (!is_dir($baseModulePath.'/Models')) mkdir($baseModulePath.'/Models', 0777, true);
            if (!is_dir($baseModulePath.'/Views')) mkdir($baseModulePath.'/Views', 0777, true);
            if (!is_dir($baseModulePath.'/Entities')) mkdir($baseModulePath.'/Entities', 0777, true);

            fopen($baseModulePath.'/Routes.php', "w");

            CLI::write(CLI::color("Module created.", 'blue'));
        } catch (\Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
        }
    }
}