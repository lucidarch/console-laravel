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

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Job extends Component
{
    public function __construct($title, $namespace, $file, $path, $relativePath, Domain $domain)
    {
        $this->setAttributes([
            'title' => $title,
            'namespace' => $namespace,
            'file' => $file,
            'realPath' => $path,
            'relativePath' => $relativePath,
            'domain' => $domain,
        ]);
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        $attributes['domain'] = $attributes['domain']->toArray();

        return $attributes;
    }
}
