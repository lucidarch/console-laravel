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
class Str
{
    /**
     * Determine the real name of the given name,
     * excluding the given pattern.
     * 	i.e. the name: "CreateArticleFeature.php" with pattern '/Feature.php'
     * 		will result in "Create Article"
     *
     * @param  [type] $name    [description]
     * @param  string $pattern [description]
     * @return [type]          [description]
     */
    public static function realName($name, $pattern = '//')
    {
        $name = preg_replace($pattern, '', $name);

        return implode(' ', preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY));
    }
}
