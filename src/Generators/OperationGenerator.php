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

use Exception;
use Lucid\Console\Str;
use Lucid\Console\Components\Operation;

/**
 * @author Ali Issa <ali@vinelab.com>
 */
class OperationGenerator extends Generator
{
    public function generate($operation, $service, $isQueueable = false, array $jobs = [])
    {
        $operation = Str::operation($operation);
        $service = Str::service($service);

        $path = $this->findOperationPath($service, $operation);

        if ($this->exists($path)) {
            throw new Exception('Operation already exists!');

            return false;
        }

        $namespace = $this->findOperationNamespace($service);

        $content = file_get_contents($this->getStub($isQueueable));

        list($useJobs, $runJobs) = self::getUsesAndRunners($jobs);

        $content = str_replace(
            ['{{operation}}', '{{namespace}}', '{{foundation_namespace}}', '{{use_jobs}}', '{{run_jobs}}'],
            [$operation, $namespace, $this->findFoundationNamespace(), $useJobs, $runJobs],
            $content
        );

        $this->createFile($path, $content);

        // generate test file
        $this->generateTestFile($operation, $service);

        return new Operation(
            $operation,
            basename($path),
            $path,
            $this->relativeFromReal($path),
            ($service) ? $this->findService($service) : null,
            $content
        );
    }

    /**
     * Generate the test file.
     *
     * @param string $operation
     * @param string $service
     */
    private function generateTestFile($operation, $service)
    {
        $content = file_get_contents($this->getTestStub());

        $namespace = $this->findOperationTestNamespace($service);
        $operationNamespace = $this->findOperationNamespace($service)."\\$operation";
        $testClass = $operation.'Test';

        $content = str_replace(
            ['{{namespace}}', '{{testclass}}', '{{operation}}', '{{operation_namespace}}'],
            [$namespace, $testClass, mb_strtolower($operation), $operationNamespace],
            $content
        );

        $path = $this->findOperationTestPath($service, $testClass);

        $this->createFile($path, $content);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub($isQueueable = false)
    {
        $stubName;
        if ($isQueueable) {
            $stubName = '/stubs/queueable-operation.stub';
        } else {
            $stubName = '/stubs/operation.stub';
        }
        return __DIR__.$stubName;
    }

    /**
     * Get the test stub file for the generator.
     *
     * @return string
     */
    private function getTestStub()
    {
        return __DIR__.'/stubs/operation-test.stub';
    }

    /**
     * Get de use to import the right class
     * Get de job run command
     * @param $job
     * @return array
     * @author jgnovais <jgnx@hotmail.com>
     */
    static private function getUseAndJobRunCommand($job)
    {
        $str = str_replace_last('\\','#', $job);
        $explode = explode('#', $str);

        $use = 'use '.$explode[0].'\\'.$explode['1'].";\n";
        $runJobs = "\t\t".'$this->run('.$explode['1'].'::class);';

        return array($use, $runJobs);
    }

    /**
     * Returns all users and all $this->run() generated
     * @param $jobs
     * @return array
     * @author jgnovais <jgnx@hotmail.com>
     */
    static private function getUsesAndRunners($jobs)
    {
        $useJobs = '';
        $runJobs = '';
        foreach ($jobs as $index => $job) {

            list($useLine, $runLine) = self::getUseAndJobRunCommand($job);
            $useJobs .= $useLine;
            $runJobs .= $runLine;
            // only add carriage returns when it's not the last job
            if ($index != count($jobs) - 1) {
                $runJobs .= "\n\n";
            }
        }
        return array($useJobs, $runJobs);
    }


}
