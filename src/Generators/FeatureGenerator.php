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
use Lucid\Console\Components\Feature;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
 class FeatureGenerator extends Generator
 {
     public function generate($feature, $service)
     {
         $feature = Str::feature($feature);
         $service = Str::service($service);

         $path = $this->findFeaturePath($service, $feature);

         if ($this->files->exists($path)) {
             $this->error('Feature already exists!');

             return false;
         }

         $namespace = $this->findFeatureNamespace($service);

         $content = file_get_contents($this->getStub());
         $content = str_replace(
             ['{{feature}}', '{{namespace}}', '{{foundation_namespace}}'],
             [$feature, $namespace, $this->findFoundationNamespace()],
             $content
         );

         $this->createFile($path, $content);

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
      * Get the stub file for the generator.
      *
      * @return string
      */
     protected function getStub()
     {
         return __DIR__.'/stubs/feature.stub';
     }
 }
