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

use Lucid\Console\Finder;
use Illuminate\Console\Command;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class ServicesListCommand extends Command
{
    use Finder;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'list:services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the services in this project.';

    public function fire()
    {
        $services = $this->listServices()->all();
        $this->table(['Service', 'Slug', 'Path'], array_map(function($service) {
            return [$service->name, $service->slug, $service->relativePath];
        }, $services));
    }
}
