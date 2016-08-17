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

use SebastianBergmann\FinderFacade\FinderFacade;
use SebastianBergmann\PHPLOC\Analyser as PHPLOCAnalyser;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Analyser
{
    use Finder;

    public function analyse()
    {
        $analyser = new PHPLOCAnalyser();

        $finder = new FinderFacade([$this->findSourceRoot()]);
        $files  = $finder->findFiles();

        return $analyser->countFiles($files, true);
    }
}
