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

use Lucid\Console\Str;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Service extends Component
{
    public function __construct($name, $realPath, $relativePath)
    {
        $this->setAttributes([
            'name' => $name,
            'slug' => Str::snake($name),
            'realPath' => $realPath,
            'relativePath' => $relativePath,
        ]);
    }

    // public function toArray()
    // {
    //     $attributes = parent::toArray();
    //
    //     unset($attributes['realPath']);
    //
    //     return $attributes;
    // }
}
