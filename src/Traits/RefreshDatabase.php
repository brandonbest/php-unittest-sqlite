<?php

namespace BrandonBest\UnittestSqlite\Traits;

use Illuminate\Support\Facades\File;

trait RefreshDatabase
{
    use SetupDatabase;

    /**
     * Refresh Database to clean version
     */
    public function refreshDatabase()
    {
        print_r(config('unittest-sqlite')); die;

        $this->checkDatabase();
        $this->runMigrations();

        copy($this->baseSqlite(), $this->copyPath());
    }

    /**
     * Run Migrations and Create the Base sqlite table
     *
     * The base table is deleted automatically when migrations are finished
     */
    public function runMigrations()
    {
        if (file_exists($this->baseSqlite())) {
            return;
        }

        $this->artisan('migrate:fresh');

        // Run Seeders

        copy($this->copyPath(), $this->baseSqlite());
        return;
    }
}