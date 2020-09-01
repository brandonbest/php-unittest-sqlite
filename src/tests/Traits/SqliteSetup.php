<?php

namespace BrandonBest\UnittestSqlite\Tests\Traits;

use BrandonBest\UnittestSqlite\Services\SetupDatabase;

trait SqliteSetup
{
    /**
     * @var SetupDatabase
     */
    public $setupDatabase;

    /**
     * Create the Database Directory
     *
     * First, delete the directory and everythting in it.
     */
    public function create_database_directory(): void
    {
        $copySqlite = $this->setupDatabase->copySqlite();
        $this->deleteDatabase();
        $this->assertFalse(file_exists($copySqlite));

        $copySqlitePath = $this->setupDatabase->copySqlitePath();
        $this->deleteDatabaseDirectory();
        $this->assertFalse(file_exists($copySqlitePath));
        app(SetupDatabase::class)->databaseDirectoryExists($copySqlite);

        $this->assertTrue(file_exists($copySqlitePath));
    }

    /**
     * Remove Base and Copy Databases
     */
    public function deleteDatabase(): void
    {
        $copySqlite = $this->setupDatabase->copySqlite();

        if (file_exists($copySqlite)) {
            unlink($copySqlite);
        }

        $basePath = $this->setupDatabase->baseSqlite();

        if (file_exists($basePath)) {
            unlink($basePath);
        }
    }

    /**
     * Remove the Directory
     */
    public function deleteDatabaseDirectory(): void
    {
        $copySqlitePath = $this->setupDatabase->copySqlitePath();

        if (file_exists($copySqlitePath)) {
            rmdir($copySqlitePath);
        }
    }
}