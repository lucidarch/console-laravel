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

        throw Exception('App namespace not set in composer.json');
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
     * Find the path to the directory of the given service name.
     *
     * @param  string $service
     *
     * @return string
     */
    public function findServicePath($service)
    {
        return $this->findSourceRoot().'/Services/'.$service;
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
        return $this->findServicePath($service).'/Features/'.$feature.'.php';
    }
}
