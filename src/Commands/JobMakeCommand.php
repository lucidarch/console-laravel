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
class JobMakeCommand extends GeneratorCommand
{
    use Finder;
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
        $domain = studly_case($this->argument('domain'));
        $job = $this->parseName($this->argument('job'));

        $path = $this->findJobPath($domain, $job);

        if ($this->files->exists($path)) {
            $this->error('Job already exists');

            return false;
        }

        // Make sure the domain directory exists
        $this->createDirectory($this->findDomainPath($domain).'/Jobs');

        // Create the job
        $namespace = $this->findDomainJobsNamespace($domain);

        $content = file_get_contents($this->getStub());
        $content = str_replace(
            ['{{job}}', '{{namespace}}', '{{foundation_namespace}}'],
            [$job, $namespace, $this->findFoundationNamespace()],
            $content
        );

        $this->createFile($path, $content);

        $this->info('Job class '.$job.' created successfully.'.
            "\n".
            "\n".
            'Find it at <comment>'.strstr($path, 'src/').'</comment>'."\n");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    public function getStub()
    {
        return __DIR__.'/stubs/job.stub';
    }

    public function getArguments()
    {
        return [
            ['domain', InputArgument::REQUIRED, 'The domain to be responsible for the job.'],
            ['job', InputArgument::REQUIRED, 'The job\'s name.'],
        ];
    }

    /**
     * Parse the job name.
     *  remove the Job.php suffix if found
     *  we're adding it ourselves.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function parseName($name)
    {
        return studly_case(preg_replace('/Job(\.php)?$/', '', $name).'Job');
    }
}
