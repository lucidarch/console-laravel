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
    public function __construct($title, $namespace, $file, $path, $relativePath, Domain $domain = null, $content = '')
    {
        $className = str_replace(' ', '', $title).'Job';
        $this->setAttributes([
            'title' => $title,
            'className' => $className,
            'namespace' => $namespace,
            'file' => $file,
            'realPath' => $path,
            'relativePath' => $relativePath,
            'domain' => $domain,
            'content' => $content,
        ]);
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        if ($attributes['domain'] instanceof Domain) {
            $attributes['domain'] = $attributes['domain']->toArray();
        }

        return $attributes;
    }
}
