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
 * @author Charalampos Raftopoulos <harris@vinelab.com>
 */
trait Filesystem
{
    /**
     * Determine if a file or directory exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public function exists($path)
    {
        return file_exists($path);
    }

    /**
     * Create a file at the given path with the given contents.
     *
     * @param string $path
     * @param string $contents
     *
     * @return bool
     */
    public function createFile($path, $contents = '', $lock = false)
    {
        return file_put_contents($path, $contents, $lock ? LOCK_EX : 0);
    }

    /**
     * Create a directory.
     *
     * @param string $path
     * @param int    $mode
     * @param bool   $recursive
     * @param bool   $force
     *
     * @return bool
     */
    public function createDirectory($path, $mode = 0755, $recursive = true, $force = true)
    {
        if ($force) {
            return @mkdir($path, $mode, $recursive);
        }

        return mkdir($path, $mode, $recursive);
    }

    /**
     * Delete an existing directory at the given path.
     *
     * @param string $path
     *
     * @return bool
     */
    public function deleteDirectory($path)
    {
        return $this->files->deleteDirectory($path, false);
    }

    /**
     * Delete an existing file at the given path.
     *
     * @param string $path
     *
     * @return bool
     */
    public function deleteFile($path)
    {
        return $this->files->delete($path);
    }

    /**
     * Check if a directory is empty.
     *
     * @param string $directory
     *
     * @return array
     */
    public function checkDirectories($directory)
    {
        return $this->files->allFiles($directory);
    }
}
