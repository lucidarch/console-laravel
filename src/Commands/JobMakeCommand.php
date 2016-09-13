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
use Lucid\Console\Generators\JobGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class JobMakeCommand extends SymfonyCommand
{
    use Finder;
    use Command;
    use Filesystem;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Job in a domain';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Job';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $generator = new JobGenerator();

        $domain = studly_case($this->argument('domain'));
        $title = $this->parseName($this->argument('job'));

        try {
            $job = $generator->generate($title, $domain);

            $this->info(
                'Job class '.$title.' created successfully.'.
                "\n".
                "\n".
                'Find it at <comment>'.$job->relativePath.'</comment>'."\n"
            );
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getArguments()
    {
        return [
            ['job', InputArgument::REQUIRED, 'The job\'s name.'],
            ['domain', InputArgument::OPTIONAL, 'The domain to be responsible for the job.'],
        ];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    public function getStub()
    {
        return __DIR__.'/../Generators/stubs/job.stub';
    }

    /**
     * Parse the job name.
     *  remove the Job.php suffix if found
     *  we're adding it ourselves.
     *
     * @param string $name
     *
     * @return string
     */
    protected function parseName($name)
    {
        return Str::job($name);
    }
}
