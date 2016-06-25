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

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\NewCommand::class,
        Commands\JobMakeCommand::class,
        Commands\ServiceMakeCommand::class,
        Commands\FeatureMakeCommand::class,
        Commands\ServicesListCommand::class,
        Commands\FeaturesListCommand::class,
        Commands\ControllerMakeCommand::class,
    ];
}
