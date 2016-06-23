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
        $service = studly_case($this->argument('service'));
        $controller = $this->parseName($this->argument('controller'));

        $path = $this->findControllerPath($service, $controller);

        if ($this->files->exists($path)) {
            $this->error('Controller already exists');

            return false;
        }

        $namespace = $this->findControllerNamespace($service);

        $content = file_get_contents($this->getStub());
        $content = str_replace(
            ['{{controller}}', '{{namespace}}', '{{foundation_namespace}}'],
            [$controller, $namespace, $this->findFoundationNamespace()],
            $content
        );

        $this->createFile($path, $content);
        $this->info('Controller class '.$controller.' created successfully.'.
            "\n".
            "\n".
            'Find it at <comment>'.strstr($path, 'src/').'</comment>'."\n");
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
     * @param  string $name
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
            return __DIR__.'/stubs/controller.plain.stub';
        }

        return __DIR__.'/stubs/controller.stub';
    }
}
