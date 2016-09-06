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
use Lucid\Console\Components\Job;

/**
  * @author Abed Halawi <abed.halawi@vinelab.com>
  */
 class JobGenerator extends Generator
 {
     public function generate($job, $domain)
     {
         $job = Str::job($job);
         $domain = Str::domain($domain);
         $path = $this->findJobPath($domain, $job);

         if ($this->exists($path)) {
             throw new Exception('Job already exists');

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

        return new Job(
            $job,
            $namespace,
            basename($path),
            $path,
            $this->relativeFromReal($path),
            $this->findDomain($domain),
            $content
        );
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
 }
