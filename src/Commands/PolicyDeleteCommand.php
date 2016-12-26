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
 * Class PolicyDeleteCommand
 *
 * @author Bernat Jufré <info@behind.design>
 *
 * @package Lucid\Console\Commands
 */
class PolicyDeleteCommand extends SymfonyCommand
{
    use Finder;
    use Command;
    use Filesystem;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'delete:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing Policy.';

    /**
     * The type of class being generated
     * @var string
     */
    protected $type = 'Policy';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        try {
            $policy = $this->parsePolicyName($this->argument('policy'));

            if ( ! $this->exists($path = $this->findPolicyPath($policy))) {
                $this->error('Policy class ' . $policy . ' cannot be found.');
            } else {
                $this->delete($path);

                $this->info('Policy class <comment>' . $policy . '</comment> deleted successfully.');
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
            ['policy', InputArgument::REQUIRED, 'The Policy\'s name.']
        ];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    public function getStub()
    {
        return __DIR__ . '/../Generators/stubs/policy.stub';
    }

    /**
     * Parse the model name.
     *
     * @param string $name
     * @return string
     */
    public function parsePolicyName($name)
    {
        return Str::policy($name);
    }
}