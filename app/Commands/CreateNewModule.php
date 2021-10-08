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
    protected $group = 'Modules';

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
    protected $usage = 'make:module [module_name] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'module_name'   => 'Specify the module name.',
        'options'       => 'Add options.'
    ];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [
        'no-controller' => 'Generate with no controllers directory.',
        'no-model' => 'Generate with no models directory.',
        'no-view' => 'Generate with no views directory.',
        'no-entity' => 'Generate with no entities directory.',
    ];

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

            $noController = in_array('no-controller', $params);
            $noModel = in_array('no-model', $params);
            $noView = in_array('no-view', $params);
            $noEntity = in_array('no-entity', $params);

            $baseModulePath = ROOTPATH.'app/Modules/'.$moduleName;
            
            if (is_dir($baseModulePath)) throw new Exception('Module already exist!');

            if (!$noController && !is_dir($baseModulePath.'/Controllers')) mkdir($baseModulePath.'/Controllers', 0777, true);
            if (!$noModel && !is_dir($baseModulePath.'/Models')) mkdir($baseModulePath.'/Models', 0777, true);
            if (!$noView && !is_dir($baseModulePath.'/Views')) mkdir($baseModulePath.'/Views', 0777, true);
            if (!$noEntity && !is_dir($baseModulePath.'/Entities')) mkdir($baseModulePath.'/Entities', 0777, true);

            fopen($baseModulePath.'/Routes.php', "w");

            CLI::write(CLI::color("Module created.", 'blue'));
        } catch (\Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
        }
    }

    private function getOptions(array $params)
    {
        
    }
}