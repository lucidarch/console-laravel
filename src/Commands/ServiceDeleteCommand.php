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
use Lucid\Console\Command;
use Lucid\Console\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * @author Charalampos Raftopoulos <harris@vinelab.com>
 */
class ServiceDeleteCommand extends SymfonyCommand
{
    use Finder;
    use Command;
    use Filesystem;

    /**
     * The base namespace for this command.
     *
     * @var string
     */
    private $namespace;

    /**
     * The Services path.
     *
     * @var string
     */
    private $path;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'delete:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../Generators/stubs/service.stub';
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        try {
            $name = ucfirst($this->argument('name'));

            if (!$this->exists($service = $this->findServicePath($name))) {
                $this->error('Service '.$name.' cannot be found.');
            } else {
                $this->delete($service);

                $this->info('Service <comment>'.$name.'</comment> deleted successfully.'."\n");

                $this->info('Please remove your registered service providers, if any.');
            }
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    public function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The service name.'],
        ];
    }
}
