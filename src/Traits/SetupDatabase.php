<?php

namespace BrandonBest\UnittestSqlite\Traits;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\File;
use Tests\CreatesApplication;

trait SetupDatabase
{
    use CreatesApplication;

    public function checkDatabase(): void
    {
        $this->validateDatabaseConfig();

        if (file_exists($this->copyPath())) {
            unlink($this->copyPath());
        }

        touch($this->copyPath());
    }

    /**
     * Pull Path to Base SQlite File
     *
     * @return string
     */
    public function baseSqlite(): string
    {
        return $this->basePath('tests/database/base.sqlite');
    }

    /**
     * Pull the Base Path Method
     *
     * @param string $path
     *
     * @return string
     */
    public function basePath(string $path)
    {
        return $this->createApplication()->basePath($path);
    }

    public function copyPath(): string
    {
        return (string) config('database.connections.sqlite.database') ?? $this->basePath('tests/database/database.sqlite');
    }

    /**
     * @throws Exception
     */
    public function validateDatabaseConfig(): void
    {
        if (config('database.default') !== 'sqlite') {
            die("Your database is not sqlite, using ". config('database.default'));
        }
    }

}