<?php

/*
 * This file is part of the lucid-console project.
 *
 * (c) Vinelab <dev@vinelab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lucid\Console\Generators;

use Lucid\Console\Str;
use Lucid\Console\Components\Feature;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class FeatureGenerator extends Generator
{
    public function generate($feature, $service, array $jobs = [])
    {
        $feature = Str::feature($feature);
        $service = Str::service($service);

        $path = $this->findFeaturePath($service, $feature);

        if ($this->exists($path)) {
            $this->error('Feature already exists!');

            return false;
        }

        $namespace = $this->findFeatureNamespace($service);

        $content = file_get_contents($this->getStub());

        $useJobs = ''; // stores the `use` statements of the jobs
        $runJobs = ''; // stores the `$this->run` statements of the jobs

        foreach ($jobs as $index => $job) {
            $useJobs .= 'use '.$job['namespace'].'\\'.$job['className'].";\n";
            $runJobs .= "\t\t".'$this->run('.$job['className'].'::class);';

            // only add carriage returns when it's not the last job
            if ($index != count($jobs) - 1) {
                $runJobs .= "\n\n";
            }
        }

        $content = str_replace(
            ['{{feature}}', '{{namespace}}', '{{foundation_namespace}}', '{{use_jobs}}', '{{run_jobs}}'],
            [$feature, $namespace, $this->findFoundationNamespace(), $useJobs, $runJobs],
            $content
        );

        $this->createFile($path, $content);

        // generate test file
        $this->generateTestFile($feature, $service);

        return new Feature(
            $feature,
            basename($path),
            $path,
            $this->relativeFromReal($path),
            $this->findService($service),
            $content
        );
    }

    /**
     * Generate the test file.
     *
     * @param  string $feature
     * @param  string $service
     */
    private function generateTestFile($feature, $service)
    {
    	$content = file_get_contents($this->getTestStub());

    	$namespace = $this->findFeatureTestNamespace($service);
    	$testClass = $feature.'Test';

    	$content = str_replace(
    		['{{namespace}}', '{{testclass}}', '{{feature}}'],
    		[$namespace, $testClass, mb_strtolower($feature)],
    		$content
    	);

    	$path = $this->findFeatureTestPath($service, $testClass);

    	$this->createFile($path, $content);
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
     * Get the test stub file for the generator.
     *
     * @return string
     */
    private function getTestStub()
    {
    	return __DIR__.'/stubs/feature-test.stub';
    }
}
