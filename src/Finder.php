<?php

/*
 * This file is part of the lucid-console project.
 *
 * (c) Vinelab <dev@vinelab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lucid\Console;

use Exception;
use InvalidArgumentException;
use Lucid\Console\Str;
use Illuminate\Support\Collection;
use Lucid\Console\Components\Feature;
use Lucid\Console\Components\Service;
use Symfony\Component\Finder\Finder as SymfonyFinder;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
trait Finder
{
    /**
     * The name of the source directory.
     *
     * @var string
     */
    protected $srcDirectoryName = 'src';

    /**
     * Get the namespace used for the application.
     *
     * @return string
     * @throws \Exception
     */
    public function findRootNamespace()
    {
        // read composer.json file contents to determine the namespace
        $composer = json_decode(file_get_contents(base_path().'/composer.json'), true);

        // see which one refers to the "src/" directory
        foreach ($composer['autoload']['psr-4'] as $namespace => $directory) {
            if ($directory === $this->srcDirectoryName.'/') return trim($namespace, '\\');
        }

        throw new Exception('App namespace not set in composer.json');
    }

    /**
     * Find the namespace of the foundation.
     *
     * @return string
     */
    public function findFoundationNamespace()
    {
        return $this->findRootNamespace().'\Foundation';
    }

    /**
     * Find the namespace for the given service name.
     *
     * @param  string $service
     *
     * @return string
     */
    public function findServiceNamespace($service)
    {
        return $this->findRootNamespace().'\\Services\\'.$service;
    }

    /**
     * get the root of the source directory.
     *
     * @return string
     */
    public function findSourceRoot()
    {
        return base_path().'/'.$this->srcDirectoryName;
    }

    /**
     * Find the root path of all the services.
     *
     * @return string
     */
    public function findServicesRootPath()
    {
        return $this->findSourceRoot().'/Services';
    }

    /**
     * Find the path to the directory of the given service name.
     *
     * @param  string $service
     *
     * @return string
     */
    public function findServicePath($service)
    {
        return $this->findServicesRootPath()."/$service";
    }

    /**
     * Find the features root path in the given service.
     *
     * @param  string $service
     *
     * @return string
     */
    public function findFeaturesRootPath($service)
    {
        return $this->findServicePath($service).'/Features';
    }

    /**
     * Find the file path for the given feature.
     *
     * @param  string $service
     * @param  string $feature
     *
     * @return string
     */
    public function findFeaturePath($service, $feature)
    {
        return $this->findFeaturesRootPath($service)."/$feature.php";
    }

    /**
     * Find the namespace for features in the given service.
     *
     * @param  string $service
     *
     * @return string
     */
    public function findFeatureNamespace($service)
    {
        return $this->findServiceNamespace($service).'\\Features';
    }

    /**
     * Find the path for the given domain.
     *
     * @param  string $domain
     *
     * @return string
     */
    public function findDomainPath($domain)
    {
        return $this->findSourceRoot().'/Domains/'.$domain;
    }

    /**
     * Find the path for the given job name.
     *
     * @param  string$domain
     * @param  string$job
     *
     * @return string
     */
    public function findJobPath($domain, $job)
    {
        return $this->findDomainPath($domain).'/Jobs/'.$job.'.php';
    }

    /**
     * Find the namespace for the given domain.
     *
     * @param  string $domain
     *
     * @return string
     */
    public function findDomainNamespace($domain)
    {
        return $this->findRootNamespace().'\\Domains\\'.$domain;
    }

    /**
     * Find the namespace for the given domain's Jobs.
     *
     * @param  string $domain
     *
     * @return string
     */
    public function findDomainJobsNamespace($domain)
    {
        return $this->findDomainNamespace($domain).'\\Jobs';
    }

    /**
     * Find the path for the give controller class.
     *
     * @param  string $service
     * @param  string $controller
     *
     * @return string
     */
    public function findControllerPath($service, $controller)
    {
        return $this->findServicePath($service).'/Http/Controllers/'.$controller.'.php';
    }

    /**
     * Find the namespace of controllers in the given service.
     *
     * @param  string $service
     *
     * @return string
     */
    public function findControllerNamespace($service)
    {
        return $this->findServiceNamespace($service).'\\Http\\Controllers';
    }

    /**
     * Get the list of services.
     *
     * @return \Illuminate\Support\Collection
     */
    public function listServices()
    {
        $finder = new SymfonyFinder();

        $services = new Collection();
        foreach ($finder->directories()->depth('== 0')->in($this->findServicesRootPath())->directories() as $dir) {
            $realPath = $dir->getRealPath();
            $services->push(new Service($dir->getRelativePathName(), $realPath, $this->relativeFromReal($realPath)));
        }

        return $services;
    }

    /**
     * Get the list of features,
     * optionally withing a specified service.
     *
     * @param string $serviceName
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function listFeatures($serviceName = '')
    {
        $services = $this->listServices();

        if (!empty($serviceName)) {
            $services = $services->filter(function($service) use($serviceName) {
                return $service->name === $serviceName || $service->slug === $serviceName;
            });

            if ($services->isEmpty()) {
                throw new InvalidArgumentException('Service "'.$serviceName.'" could not be found.');
            }
        }


        $features = [];
        foreach ($services as $service) {
            $serviceFeatures = new Collection();
            $finder = new SymfonyFinder();
            $files = $finder
                ->name('*Feature.php')
                ->in($this->findFeaturesRootPath($service->name))
                ->files();
            foreach ($files as $file) {
                $fileName = $file->getRelativePathName();
                $title = Str::realName($fileName, '/Feature.php/');
                $realPath = $file->getRealPath();
                $relativePath = $this->relativeFromReal($realPath);

                $serviceFeatures->push(new Feature($title, $fileName, $realPath, $relativePath, $service));
            }

            // add to the features array as [service_name => Collection(Feature)]
            $features[$service->name] = $serviceFeatures;
        }

        return $features;
    }

    /**
     * Get the relative version of the given real path.
     *
     * @param  string $path
     * @param  string $needle
     *
     * @return string
     */
    protected function relativeFromReal($path, $needle = 'src/')
    {
        return strstr($path, $needle);
    }
}
