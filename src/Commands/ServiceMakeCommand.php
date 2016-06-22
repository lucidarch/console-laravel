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
use Illuminate\Config\Repository as Config;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class ServiceMakeCommand extends GeneratorCommand
{
    use Finder;
    use Filesystem;

    /**
     * The base namespace for this command.
     *
     * @var string
     */
    private $namespace;

    /**
     * The Services path
     *
     * @var string
     */
    private $path;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Service';

    /**
     * The directories to be created under the service directory.
     *
     * @var array
     */
    protected $directories = [
        'Console/',
		'Database/',
		'Database/Migrations/',
		'Database/Seeds/',
		'Http/',
		'Http/Controllers/',
		'Http/Middleware/',
		'Http/Requests/',
		'Providers/',
        'Features/',
		'resources/',
		'resources/lang/',
		'resources/views/',
    ];

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/service.stub';
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $name = studly_case($this->getNameInput());

        $slug = snake_case($name);

        $path = $this->getPath($name);

        if ($this->files->exists($path)) {
            $this->error('Service already exists!');

            return false;
        }

        // create service directory
        $this->createDirectory($path);
        // create .gitkeep file in it
        $this->createFile($path.'/.gitkeep');

        $this->createServiceDirectories($path);

        $this->addServiceProviders($name, $slug, $path);

        $this->addRoutesFile($name, $slug, $path);

        $this->addWelcomeViewFile($path);

        $this->info('Service '.$name.' created successfully.'."\n");

        $rootNamespace = $this->findRootNamespace();
        $serviceNamespace = $this->findServiceNamespace($name);

        $serviceProvider = $serviceNamespace.'\\Providers\\'.$name.'ServiceProvider';

        $this->info('Activate it by registering '.
            '<comment>'.$serviceProvider.'</comment> '.
            "\n".
            'in <comment>'.$rootNamespace.'\Foundation\Providers\ServiceProvider@register</comment> '.
            'with the following:'.
            "\n"
        );

        $this->info('<comment>$this->app->register(\''.$serviceProvider.'\');</comment>'."\n");
    }

    /**
     * {@inheritdoc}
     */
    public function getPath($name)
    {
        return $this->findServicePath($name);
    }

    /**
     * Create the default directories at the given service path.
     *
     * @param  string $path
     *
     * @return void
     */
    public function createServiceDirectories($path)
    {
        foreach ($this->directories as $directory) {
            $this->createDirectory($path.'/'.$directory);
            $this->createFile($path.'/'.$directory.'/.gitkeep');
        }
    }

    /**
     * Add the corresponding service provider for the created service.
     *
     * @param string $name
     * @param string $path
     *
     * @return bool
     */
    public function addServiceProviders($name, $slug, $path)
    {
        $namespace = $this->findServiceNamespace($name).'\\Providers';

        $this->createRegistrationServiceProvider($name, $path, $slug, $namespace);

        $this->createRouteServiceProvider($name, $path, $slug, $namespace);
    }

    /**
     * Create the service provider that registers this service.
     *
     * @param  string $name
     * @param  string $path
     */
    public function createRegistrationServiceProvider($name, $path, $slug, $namespace)
    {
        $content = file_get_contents(__DIR__.'/stubs/serviceprovider.stub');
        $content = str_replace(
            ['{{name}}', '{{slug}}', '{{namespace}}'],
            [$name, $slug, $namespace],
            $content
        );

        $this->createFile($path.'/Providers/'.$name.'ServiceProvider.php', $content);
    }

    /**
     * Create the routes service provider file.
     *
     * @param  string $name
     * @param  string $path
     * @param  string $slug
     * @param  string $namespace
     */
    public function createRouteServiceProvider($name, $path, $slug, $namespace)
    {
        $serviceNamespace = $this->findServiceNamespace($name);
        $controllers = $serviceNamespace.'\Http\Controllers';
        $foundation = $this->findFoundationNamespace();

        $content = file_get_contents(__DIR__.'/stubs/routeserviceprovider.stub');
        $content = str_replace(
            ['{{name}}', '{{namespace}}', '{{controllers_namespace}}', '{{foundation_namespace}}'],
            [$name, $namespace, $controllers, $foundation],
            $content
        );

        $this->createFile($path.'/Providers/RouteServiceProvider.php', $content);
    }

    /**
     * Add the routes file.
     *
     * @param string $name
     * @param string $slug
     * @param string $path
     */
    public function addRoutesFile($name, $slug, $path)
    {
        $controllers = 'src/Services/'.$name.'/Http/Controllers';

        $content = file_get_contents(__DIR__.'/stubs/routes.stub');
        $content = str_replace(['{{slug}}', '{{controllers_path}}'], [$slug, $controllers], $content);

        $this->createFile($path.'/Http/routes.php', $content);
    }

    /**
     * Add the welcome view file.
     *
     * @param string $path
     */
    public function addWelcomeViewFile($path)
    {
        $this->createFile(
            $path.'/resources/views/welcome.blade.php',
            file_get_contents(__DIR__.'/stubs/welcome.blade.stub')
        );
    }
}
