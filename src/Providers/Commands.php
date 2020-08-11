<?php

namespace BrandonBest\UnittestSqlite\Providers;

/**
 * This file is part of Prion Development's Brute Package,
 * an brute force monitor and blocker for Lumen.
 *
 * @license MIT
 * @company Brandon Best
 * @package PHP UnitTtest Sqlite
 */

use BrandonBest\Console\Commands\SqliteDeleteTest;
use Illuminate\Support\ServiceProvider;

class Commands extends ServiceProvider implements ProviderInterface
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    public $commands = [
        'SqliteDeleteBase' => [
            'class' => SqliteDeleteTest::class,
            'command' => 'command.unittest-sqlite.delete-rate',
        ],
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->registerCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Loop Through All Commands and Register them
     */
    protected function registerCommands(): void
    {
        $commandClasses = [];
        foreach ($this->commands as $key => $command) {
            $commandClasses[] = $command['class'];
        }

        $this->commands($commandClasses);
    }

    /**
     * Register a Single Command with a Class
     *
     * @param $class
     * @param $command
     */
    protected function registerCommand($class, $command): void
    {
        $this->app->singleton($command, function ($app) use ($class) {
            return new $class($app['files']);
        });
    }

    /**
     * Pull all Commands for Brute
     *
     * @return array
     */
    public function all(): array
    {
        return array_column($this->commands, 'command');
    }
}