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

use Illuminate\Support\ServiceProvider;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class LucidServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/lucid.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');

        $dashboardEnabled = $this->app['config']->get('lucid.dashboard');

        if ($dashboardEnabled === null) {
            $dashboardEnabled = $this->app['config']->get('app.debug');
        }

        if ($dashboardEnabled === true) {
            if (!$this->app->routesAreCached() ) {
                require_once __DIR__.'/Http/routes.php';
            }
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lucid');

        $this->publishes([
             __DIR__.'/../resources/assets' => public_path('vendor/lucid'),
        ], 'public');
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/lucid.php';
        $this->mergeConfigFrom($configPath, 'lucid');
    }

    /**
     * Return path to config file.
     *
     * @return string
     */
    private function getConfigPath()
    {
        return config_path('lucid.php');
    }
}
