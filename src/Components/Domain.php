<?php

/*
 * This file is part of the lucid-console project.
 *
 * (c) Vinelab <dev@vinelab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lucid\Console\Components;

use Illuminate\Support\Str;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Domain extends Component
{
    public function __construct($name, $namespace, $path, $relativePath)
    {
        $this->setAttributes([
            'name' => $name,
            'slug' => Str::studly($name),
            'namespace' => $namespace,
            'realPath' => $path,
            'relativePath' => $relativePath,
        ]);
    }
}
