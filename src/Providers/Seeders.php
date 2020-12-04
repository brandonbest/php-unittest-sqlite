<?php

namespace BrandonBest\UnittestSqlite\Providers;

/**
 * This file is part of Prion Development's Unittest Sqlite Package,
 * an speed improvement package for unit tests.
 *
 * @license MIT
 * @company Prion Development
 * @package PHP UnitTest Sqlite
 */

use Illuminate\Support\ServiceProvider;

class Seeders extends ServiceProvider implements ProviderInterface
{
    /**
     * Publish the Configuration File
     */
    public function boot(): void
    {
        $app_path = app()->basePath('database/seeds/UnitTestSeeder.php');
        $this->publishes([
            __DIR__ . '/../../database/seeds/UnitTestSeeder.php' => $app_path,
        ], 'UnitTestSeeder');
    }

    public function register(): void
    {
        //
    }
}
