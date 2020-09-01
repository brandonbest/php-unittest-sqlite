<?php

namespace BrandonBest\UnittestSqlite\Traits;

use BrandonBest\UnittestSqlite\Exceptions\UnittestSqliteSetupException;
use ErrorException;

trait SetupDatabase
{
    /**
     * Validate the Database is Sqlite
     *
     * @throws UnittestSqliteSetupException
     */
    public function validateDatabase(): Void
    {
        $this->isSqlite();

        $copySqlite = $this->copySqlite();
        if (file_exists($copySqlite)) {
            unlink($copySqlite);
        }

        $this->createCopySqlite();
    }

    /**
     * Pull Path to Base SQlite File
     *
     * @return string
     */
    public function baseSqlite(): string
    {
        return $this->copySqlitePath() . '/base.sqlite';
    }

    /**
     * Full file path of sqlite
     *
     * @return string
     */
    public function copySqlite(): string
    {
        $file = $this->configCopySqlite();
        if (stristr($file, '.sqlite')) {
            return $file;
        }

        return $this->defaultCopySqlite();
    }

    /**
     * Pull the Sqlite Path without a File
     *
     * @return string
     */
    public function copySqlitePath(): string
    {
        $copySqlite = $this->copySqlite();
        $copySqlitePath = explode('/', $copySqlite);
        array_pop($copySqlitePath);
        $copySqlitePath = implode('/', $copySqlitePath);
        return $copySqlitePath;
    }

    /**
     * Create the Sqlite Fille
     *
     * @throws UnittestSqliteSetupException
     */
    public function copySqliteCreate()
    {
        $file = $this->copySqlite();

        try {
            touch($file);
        } catch (ErrorException $e) {
            throw new UnittestSqliteSetupException('The file or path does not exist: ' . $file);
        }
    }

    /**
     * Default Config Sqlite File
     *
     * @return string
     */
    public function configCopySqlite(): string
    {
        return (string) config('database.connections.sqlite.database');
    }

    /**
     * Default Sqlite file (if config does not exist)
     *
     * @return string
     */
    public function defaultCopySqlite(): string
    {
        return $this->basePath('tests/database/database.sqlite');
    }

    /**
     * Create Directories if Do Not Exist
     *
     * @param string $file
     */
    public function databaseDirectoryExists(string $file): void
    {
        $filePath = explode('/', $file);
        array_pop($filePath);
        $fullFilePath = '';

        foreach ($filePath as $directory) {
            if (empty($directory)) {
                continue;
            }

            $fullFilePath .= '/' . $directory;

            if (!file_exists($fullFilePath)) {
                mkdir($fullFilePath);
            }
        }
    }

    /**
     * Create a Sqlite Directory
     */
    public function createCopySqlite(): void
    {
        $file = $this->copySqlite();

        try {
            $this->databaseDirectoryExists($file);
        } catch (ErrorException $e) {
            $file = $this->defaultCopySqlite();
            $this->databaseDirectoryExists($file);
        }
    }

    /**
     * Pull the Base Path Method
     *
     * @param string $path
     *
     * @return string
     */
    public function basePath(string $path): string
    {
        return base_path($path);
    }

    /**
     * @throws UnittestSqliteSetupException
     */
    public function isSqlite(): bool
    {
        if (config('database.default') !== 'sqlite') {
            throw new UnittestSqliteSetupException("Your database is not sqlite, using ". config('database.default'));
        }

        return true;
    }
}
