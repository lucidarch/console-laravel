<?php

namespace Lucid\Console\Commands;

use Exception;
use Lucid\Console\Str;
use Lucid\Console\Command;
use Lucid\Console\Filesystem;
use Lucid\Console\Finder;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Class ModelDeleteCommand
 *
 * @author Bernat Jufré <info@behind.design>
 *
 * @package Lucid\Console\Commands
 */
class ModelDeleteCommand extends SymfonyCommand
{
    use Finder;
    use Command;
    use Filesystem;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'delete:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing Eloquent Model.';

    /**
     * The type of class being generated
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        try {
            $model = $this->parseModelName($this->argument('model'));

            if ( ! $this->exists($path = $this->findModelPath($model))) {
                $this->error('Model class ' . $model . ' cannot be found.');
            } else {
                $this->delete($path);

                $this->info('Model class <comment>' . $model . '</comment> deleted successfully.');
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
    public function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'The Model\'s name.']
        ];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    public function getStub()
    {
        return __DIR__ . '/../Generators/stubs/model.stub';
    }

    /**
     * Parse the model name.
     *
     * @param string $name
     * @return string
     */
    public function parseModelName($name)
    {
        return Str::model($name);
    }
}