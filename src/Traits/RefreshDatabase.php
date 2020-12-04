<?php

namespace BrandonBest\UnittestSqlite\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Artisan;

trait RefreshDatabase
{
    use SetupDatabase;

    /**
     * Refresh Database to clean version
     */
    public function refreshDatabase()
    {
        $this->validateDatabase();
        $this->copySqliteCreate();
        $this->runMigrations();

        copy($this->baseSqlite(), $this->copySqlite());
    }

    /**
     * Run Migrations and Create the Base sqlite table
     *
     * 1. If the base Sqlite file does not exist, create the copy path
     * 2. Run migrations on the copy path
     * 3. Copy the copy to the base
     *
     * The base table is deleted automatically when migrations are finished
     */
    public function runMigrations()
    {
        if (file_exists($this->baseSqlite())) {
            return;
        }

        config(['database.connections.sqlite.database' => $this->copySqlite()]);
        if (method_exists($this, 'withoutMockingConsoleOutput')) {
            $this->withoutMockingConsoleOutput()->artisan('migrate');
        } else {
            Artisan::call('migrate');
        }

        try {
            $this->seed('UnittestSeeder');
        } catch (BindingResolutionException $e) {
            //
        }

        copy($this->copySqlite(), $this->baseSqlite());
        return;
    }
}
