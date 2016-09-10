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

use Lucid\Console\Str;
use Lucid\Console\Finder;
use Lucid\Console\Command;
use Lucid\Console\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * @author Charalampos Raftopoulos <harris@vinelab.com>
 */
class FeatureDeleteCommand extends SymfonyCommand
{
    use Finder;
    use Command;
    use Filesystem;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'delete:feature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing Feature in a service';

    /**
     * The type of class being deleted.
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
        try {
            $service = studly_case($this->argument('service'));
            $title = $this->parseName($this->argument('feature'));

            if (!$this->exists($feature = $this->findFeaturePath($service, $title))) {
                $this->error('Feature class '.$title.' cannot be found.');
            } else {
                $this->delete($feature);

                $this->info('Feature class <comment>'.$title.'</comment> deleted successfully.');
            }
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
            ['service', InputArgument::REQUIRED, 'The service in which the feature should be deleted from.'],
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
        return __DIR__.'/../Generators/stubs/feature.stub';
    }

    /**
     * Parse the feature name.
     *  remove the Feature.php suffix if found
     *  we're adding it ourselves.
     *
     * @param string $name
     *
     * @return string
     */
    protected function parseName($name)
    {
        return Str::feature($name);
    }
}
