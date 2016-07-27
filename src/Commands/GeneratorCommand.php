<?php

/*
 * This file is part of the lucid-console project.
 *
 * (c) Vinelab <dev@vinelab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lucid\Console\Commands;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class GeneratorCommand extends IlluminateGeneratorCommand
{
    public function __construct(Filesystem $files, Generator $generator)
    {
        parent::__construct($files);

        $this->generator = $generator;
    }
}
