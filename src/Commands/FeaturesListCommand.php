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
use Symfony\Component\Console\Input\InputArgument;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 */
class FeaturesListCommand extends Command
{
    use Finder;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'list:features';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the features.';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        foreach ($this->listFeatures($this->argument('service')) as $service => $features) {
            $this->comment("\n$service\n");
            $this->table(['Feature', 'Service', 'File', 'Path'], $features);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['service', InputArgument::OPTIONAL, 'The service to list the features of.'],
        ];
    }
}
