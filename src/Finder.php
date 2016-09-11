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
use Illuminate\Support\Collection;
use Lucid\Console\Components\Feature;
use Lucid\Console\Components\Service;
use Lucid\Console\Components\Domain;
use Lucid\Console\Components\Job;
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

    public function fuzzyFind($query)
    {
        $finder = new SymfonyFinder();

        $files = $finder->in($this->findServicesRootPath().'/*/Features') // features
            ->in($this->findDomainsRootPath().'/*/Jobs') // jobs
            ->name('*.php')
            ->files();

        $matches = [
            'jobs' => [],
            'features' => [],
        ];

        foreach ($files as $file) {
            $base = $file->getBaseName();
            $name = str_replace(['.php', ' '], '', $base);

            $query = str_replace(' ', '', trim($query));

            similar_text($query, mb_strtolower($name), $percent);

            if ($percent > 35) {
                if (strpos($base, 'Feature.php')) {
                    $matches['features'][] = [$this->findFeature($name)->toArray(), $percent];
                } elseif (strpos($base, 'Job.php')) {
                    $matches['jobs'][] = [$this->findJob($name)->toArray(), $percent];
                }
            }
        }

        // sort the results by their similarity percentage
        $this->sortFuzzyResults($matches['jobs']);
        $this->sortFuzzyResults($matches['features']);

        $matches['features'] = $this->mapFuzzyResults($matches['features']);
        $matches['jobs'] = array_map(function ($result) {
            return $result[0];
        }, $matches['jobs']);

        return $matches;
    }

    /**
     * Sort the fuzzy-find results.
     *
     * @param array &$results
     *
     * @return bool
     */
    private function sortFuzzyResults(&$results)
    {
        return usort($results, function ($resultLeft, $resultRight) {
            return $resultLeft[1] < $resultRight[1];
        });
    }

     /**
      * Map the fuzzy-find results into the data
      * that should be returned.
      *
      * @param  array $results
      *
      * @return array
      */
     private function mapFuzzyResults($results)
     {
         return array_map(function ($result) {
            return $result[0];
        }, $results);
     }

    /**
     * Get the namespace used for the application.
     *
     * @return string
     *
     * @throws \Exception
     */
    public function findRootNamespace()
    {
        // read composer.json file contents to determine the namespace
        $composer = json_decode(file_get_contents(base_path().'/composer.json'), true);

        // see which one refers to the "src/" directory
        foreach ($composer['autoload']['psr-4'] as $namespace => $directory) {
            if ($directory === $this->srcDirectoryName.'/') {
                return trim($namespace, '\\');
            }
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
        return 'Lucid\Foundation';
    }

    /**
     * Find the namespace for the given service name.
     *
     * @param string $service
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
     * @param string $service
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
     * @param string $service
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
     * @param string $service
     * @param string $feature
     *
     * @return string
     */
    public function findFeaturePath($service, $feature)
    {
        return $this->findFeaturesRootPath($service)."/$feature.php";
    }

    /**
     * Find the test file path for the given feature.
     *
     * @param string $service
     * @param string $feature
     *
     * @return string
     */
    public function findFeatureTestPath($service, $test)
    {
        return $this->findServicePath($service)."/Tests/Features/$test.php";
    }

    /**
     * Find the namespace for features in the given service.
     *
     * @param string $service
     *
     * @return string
     */
    public function findFeatureNamespace($service)
    {
        return $this->findServiceNamespace($service).'\\Features';
    }

    /**
     * Find the namespace for features tests in the given service.
     *
     * @param string $service
     *
     * @return string
     */
    public function findFeatureTestNamespace($service)
    {
        return $this->findServiceNamespace($service).'\\Tests\\Features';
    }

    /**
     * Find the root path of domains.
     *
     * @return string
     */
    public function findDomainsRootPath()
    {
        return $this->findSourceRoot().'/Domains';
    }

    /**
     * Find the path for the given domain.
     *
     * @param string $domain
     *
     * @return string
     */
    public function findDomainPath($domain)
    {
        return $this->findDomainsRootPath()."/$domain";
    }

    /**
     * Get the list of domains.
     *
     * @return \Illuminate\Support\Collection;
     */
    public function listDomains()
    {
        $finder = new SymfonyFinder();
        $directories = $finder
            ->depth(0)
            ->in($this->findDomainsRootPath())
            ->directories();

        $domains = new Collection();
        foreach ($directories as $directory) {
            $name = $directory->getRelativePathName();

            $domain = new Domain(
                Str::realName($name),
                $this->findDomainNamespace($name),
                $directory->getRealPath(),
                $this->relativeFromReal($directory->getRealPath())
            );

            $domains->push($domain);
        }

        return $domains;
    }

    /**
     * List the jobs per domain,
     * optionally provide a domain name to list its jobs.
     *
     * @param string $domain
     *
     * @return Collection
     */
    public function listJobs($domainName = null)
    {
        $domains = ($domainName) ? [$this->findDomain(Str::domain($domainName))] : $this->listDomains();

        $jobs = new Collection();
        foreach ($domains as $domain) {
            $path = $domain->realPath;

            $finder = new SymfonyFinder();
            $files = $finder
                ->name('*Job.php')
                ->in($path.'/Jobs')
                ->files();

            $jobs[$domain->name] = new Collection();

            foreach ($files as $file) {
                $name = $file->getRelativePathName();
                $job = new Job(
                    Str::realName($name, '/Job.php/'),
                    $this->findDomainJobsNamespace($domain->name),
                    $name,
                    $file->getRealPath(),
                    $this->relativeFromReal($file->getRealPath()),
                    $domain,
                    file_get_contents($file->getRealPath())
                );

                $jobs[$domain->name]->push($job);
            }
        }

        return $jobs;
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
     * @param string $domain
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
     * @param string $domain
     *
     * @return string
     */
    public function findDomainJobsNamespace($domain)
    {
        return $this->findDomainNamespace($domain).'\Jobs';
    }

    /**
     * Find the namespace for the given domain's Jobs.
     *
     * @param string $domain
     *
     * @return string
     */
    public function findDomainJobsTestsNamespace($domain)
    {
        return $this->findDomainNamespace($domain).'\Tests\Jobs';
    }

    /**
     * Find the test path for the given job.
     *
     * @param string $domain
     * @param string $job
     *
     * @return string
     */
    public function findJobTestPath($domain, $jobTest)
    {
        return $this->findDomainPath($domain).DIRECTORY_SEPARATOR.'Tests'.DIRECTORY_SEPARATOR.'Jobs'.DIRECTORY_SEPARATOR.$jobTest.'.php';
    }

    /**
     * Find the path for the give controller class.
     *
     * @param string $service
     * @param string $controller
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
     * @param string $service
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
     * Find the service for the given service name.
     *
     * @param string $service
     *
     * @return \Lucid\Console\Components\Service
     */
    public function findService($service)
    {
        $finder = new SymfonyFinder();
        $dirs = $finder->name($service)->in($this->findServicesRootPath())->directories();
        if ($dirs->count() < 1) {
            throw new Exception('Service "'.$service.'" could not be found.');
        }

        foreach ($dirs as $dir) {
            $path = $dir->getRealPath();

            return  new Service(Str::service($service), $path, $this->relativeFromReal($path));
        }
    }

    /**
     * Find the domain for the given domain name.
     *
     * @param string $domain
     *
     * @return \Lucid\Console\Components\Domain
     */
    public function findDomain($domain)
    {
        $finder = new SymfonyFinder();
        $dirs = $finder->name($domain)->in($this->findDomainsRootPath())->directories();
        if ($dirs->count() < 1) {
            throw new Exception('Domain "'.$domain.'" could not be found.');
        }

        foreach ($dirs as $dir) {
            $path = $dir->getRealPath();

            return  new Domain(
                Str::service($domain),
                $this->findDomainNamespace($domain),
                $path,
                $this->relativeFromReal($path)
            );
        }
    }

    /**
     * Find the feature for the given feature name.
     *
     * @param string $name
     *
     * @return \Lucid\Console\Components\Feature
     */
    public function findFeature($name)
    {
        $name = Str::feature($name);
        $fileName = "$name.php";

        $finder = new SymfonyFinder();
        $files = $finder->name($fileName)->in($this->findServicesRootPath())->files();
        foreach ($files as $file) {
            $path = $file->getRealPath();
            $serviceName = strstr($file->getRelativePath(), DIRECTORY_SEPARATOR, true);
            $service = $this->findService($serviceName);
            $content = file_get_contents($path);

            return new Feature(
                Str::realName($name, '/Feature/'),
                $fileName,
                $path,
                $this->relativeFromReal($path),
                $service,
                $content
            );
        }
    }

    /**
     * Find the feature for the given feature name.
     *
     * @param string $name
     *
     * @return \Lucid\Console\Components\Feature
     */
    public function findJob($name)
    {
        $name = Str::job($name);
        $fileName = "$name.php";

        $finder = new SymfonyFinder();
        $files = $finder->name($fileName)->in($this->findDomainsRootPath())->files();
        foreach ($files as $file) {
            $path = $file->getRealPath();
            $domainName = strstr($file->getRelativePath(), '/', true);
            $domain = $this->findDomain($domainName);
            $content = file_get_contents($path);

            return new Job(
                Str::realName($name, '/Job/'),
                $this->findDomainJobsNamespace($domainName),
                $fileName,
                $path,
                $this->relativeFromReal($path),
                $domain,
                $content
            );
        }
    }

    /**
     * Get the list of features,
     * optionally withing a specified service.
     *
     * @param string $serviceName
     *
     * @return \Illuminate\Support\Collection
     *
     * @throws \Exception
     */
    public function listFeatures($serviceName = '')
    {
        $services = $this->listServices();

        if (!empty($serviceName)) {
            $services = $services->filter(function ($service) use ($serviceName) {
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
     * @param string $path
     * @param string $needle
     *
     * @return string
     */
    protected function relativeFromReal($path, $needle = 'src/')
    {
        return strstr($path, $needle);
    }
}
