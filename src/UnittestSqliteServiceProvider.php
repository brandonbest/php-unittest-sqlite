<?php

namespace BrandonBest\UnittestSqlite;

/**
 * This is part of the PHP Sqlite Unittest package
 *
 * @license MIT
 * @company Brandon Best
 * @package PHP Unittest Sqlite
 */

use Illuminate\Support\ServiceProvider;

class UnittestSqliteServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $setup = [
        \BrandonBest\UnittestSqlite\Providers\Config::class,
        \BrandonBest\UnittestSqlite\Providers\Seeders::class,
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        app(\BrandonBest\UnittestSqlite\Providers\Commands::class, ['app' => $this->app])->boot();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPackage();
        $this->registerProviders();
    }

    /**
     * Register Brute in Laravel/Lumen
     *
     */
    private function registerPackage(): void
    {
        $this->app->bind('unittest-sqlite', function ($app) {
            return app(UnittestSqlite::class, ['app' => $app]);
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('\BrandonBest\UnittestSqlite\UnittestSqlite', 'UnittestSqlite\UnittestSqlite');
    }

    /**
     * Register Additional Providers, such as config setup
     * and command setup
     */
    private function registerProviders(): void
    {
        foreach($this->setup as $setup) {
            $this->app->register($setup);
        }
    }
}
