<?php

namespace BrandonBest\UnittestSqlite\Tests\Unit;

use BrandonBest\Console\Commands\SqliteDeleteTest;
use BrandonBest\UnittestSqlite\Exceptions\UnittestSqliteSetupException;
use BrandonBest\UnittestSqlite\Services\SetupDatabase;
use BrandonBest\UnittestSqlite\Tests\Traits\SqliteSetup;
use BrandonBest\UnittestSqlite\Tests\UnittestSqliteTestCase;

class CommandSqliteDeleteTest extends UnittestSqliteTestCase
{
    use SqliteSetup;

    /**
     * @var SetupDatabase
     */
    public $setupDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Mock the Configuration Copy Path
        $this->setupDatabase = $this->partialMock(SetupDatabase::class, function ($mock) {
            $mock->shouldReceive('basePath')->andReturnUsing(function($path) {
                return local_base_path($path);
            });
        });

        $path = app(SetupDatabase::class)->defaultCopySqlite();
        $this->setupDatabase = $this->partialMock(SetupDatabase::class, function ($mock) use ($path) {
            $mock->shouldReceive('configCopySqlite')->andReturn($path);

            $mock->shouldReceive('basePath')->andReturnUsing(function($path) {
                return local_base_path($path);
            });
        });

        $this->create_database_directory();

        $this->setupDatabase->validateDatabase();
    }

    /**
     * Destroy the Database and Database Directory
     */
    public function tearDown(): void
    {
        parent::tearDown();

        $this->deleteDatabase();
        $this->deleteDatabaseDirectory();
    }

    /**
     * @test
     */
    public function error_if_not_sqlite()
    {
        config(['database.default' => 'mysql']);

        $this->expectException(UnittestSqliteSetupException::class);
        $this->setupDatabase->validateDatabase();
    }

    /**
     * @test
     */
    public function error_if_base_database_exists()
    {
        $baseDb = $this->setupDatabase->baseSqlite();
        if (file_exists($baseDb)) {
            unlink($baseDb);
        }

        $error = app(SqliteDeleteTest::class)->outputDoesNotExist;
        $this->artisan('sqlite:delete')->expectsOutput($error);
    }

    /**
     * @test
     */
    public function successful_because_base_database_exists()
    {
        $baseDb = $this->setupDatabase->baseSqlite();
        if (!file_exists($baseDb)) {
            touch($baseDb);
        }

        $success = app(SqliteDeleteTest::class)->outputSuccessfulPrefix;
        $this->artisan('sqlite:delete')->expectsOutput($success . $baseDb);
    }
}
