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
use Symfony\Component\Console\Input\InputArgument;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class FeatureMakeCommand extends GeneratorCommand
{
    use Finder;
    use Filesystem;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:feature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Feature in a service';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Feature';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $service = studly_case($this->argument('service'));
        $feature = $this->parseName($this->argument('feature'));

        $path = $this->findFeaturePath($service, $feature);

        if ($this->files->exists($path)) {
            $this->error('Feature already exists!');

            return false;
        }

        $namespace = $this->findServiceNamespace($service).'\\Features';

        $content = file_get_contents($this->getStub());
        $content = str_replace(
            ['{{feature}}', '{{namespace}}', '{{foundation_namespace}}'],
            [$feature, $namespace, $this->findFoundationNamespace()],
            $content
        );

        $this->createFile($path, $content);

        $this->info('Feature class '.$feature.' created successfully.'.
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
            ['service', InputArgument::REQUIRED, 'The service in which the feature should be implemented.'],
            ['feature', InputArgument::REQUIRED, 'The feature\'s name.'],
        ];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/feature.stub';
    }

    /**
     * Parse the feature name.
     *  remove the Feature.php suffix if found
     *  we're adding it ourselves.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function parseName($name)
    {
        return studly_case(preg_replace('/Feature(\.php)?$/', '', $name).'Feature');
    }
}
