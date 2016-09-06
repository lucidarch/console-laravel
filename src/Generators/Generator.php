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

use Lucid\Console\Finder;
use Lucid\Console\Filesystem;
use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Generator
{
    use Finder;
    use Filesystem;
}
