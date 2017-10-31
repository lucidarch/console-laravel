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
 use Lucid\Console\Parser;
 use Illuminate\Console\Command;
 use Symfony\Component\Console\Input\InputArgument;

 /**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
 class FeatureDescribeCommand extends Command
 {

     use Finder;

     /**
      * The console command name.
      *
      * @var string
      */
     protected $name = 'describe:feature';

     /**
      * The console command description.
      *
      * @var string
      */
     protected $description = 'List the jobs of the specified feature in sequential order.';

     /**
      * Execute the console command.
      *
      * @return bool|null
      */
     public function handle()
     {
         if ($feature = $this->findFeature($this->argument('feature'))) {
            $parser = new Parser();
            $jobs = $parser->parseFeatureJobs($feature);

            $features = [];
            foreach ($jobs as $index => $job) {
                $features[$feature->title][] = [$index+1, $job->title, $job->domain->name, $job->relativePath];
            }

            foreach ($features as $feature => $jobs) {
                $this->comment("\n$feature\n");
                $this->table(['', 'Job', 'Domain', 'Path'], $jobs);
            }

            return true;
        }

        throw new InvalidArgumentException('Feature with name "'.$this->argument('feature').'" not found.');
     }


     /**
      * Get the console command arguments.
      *
      * @return array
      */
     protected function getArguments()
     {
         return [
             ['feature', InputArgument::REQUIRED, 'The feature name to list the jobs of.'],
         ];
     }
 }
