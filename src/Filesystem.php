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
     * Create an empty directory at the given path.
     *
     * @param string $path
     *
     * @return bool
     */
    public function createDirectory($path)
    {
        return $this->files->makeDirectory($path, 0755, true, true);
    }

    /**
     * Create a file at the given path with the given contents.
     *
     * @param string $path
     * @param string $contents
     *
     * @return bool
     */
    public function createFile($path, $contents = '')
    {
        return $this->files->put($path, $contents);
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
