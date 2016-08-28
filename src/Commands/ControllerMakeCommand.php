<?php

/*
 * This file is part of the lucid-console project.
 *
 * (c) Vinelab <dev@vinelab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lucid\Console\Commands;

use Lucid\Console\Finder;
use Lucid\Console\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Lucid\Console\Generators\ControllerGenerator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class ControllerMakeCommand extends GeneratorCommand
{
    use Finder;
    use Filesystem;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource Controller class in a service';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $generator = app(ControllerGenerator::class);

        $service = $this->argument('service');
        $name = $this->argument('controller');

        try {
            $controller = $generator->generate($name, $service);

            $this->info('Controller class created successfully.'.
                "\n".
                "\n".
                'Find it at <comment>'.strstr($controller, 'src/').'</comment>'."\n"
            );
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['service', InputArgument::REQUIRED, 'The service in which the controller should be generated.'],
            ['controller', InputArgument::REQUIRED, 'The controller\'s name.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', null, InputOption::VALUE_NONE, 'Generate an empty controller class.'],
        ];
    }

    /**
     * Parse the feature name.
     *  remove the Controller.php suffix if found
     *  we're adding it ourselves.
     *
     * @param string $name
     *
     * @return string
     */
    protected function parseName($name)
    {
        return studly_case(preg_replace('/Controller(\.php)?$/', '', $name).'Controller');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('plain')) {
            return __DIR__.'/../Generators/stubs/controller.plain.stub';
        }

        return __DIR__.'/../Generators/stubs/controller.stub';
    }
}
