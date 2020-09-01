<?php

namespace BrandonBest\UnittestSqlite\Tests\Unit;

use BrandonBest\UnittestSqlite\Services\RefreshDatabase;
use BrandonBest\UnittestSqlite\Services\SetupDatabase;
use BrandonBest\UnittestSqlite\Tests\Traits\SqliteSetup;
use BrandonBest\UnittestSqlite\Tests\UnittestSqliteTestCase;

class RefreshDatabaseTest extends UnittestSqliteTestCase
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
    }

    /**
     * @test
     */
    public function makes_base_and_copy_sqlite_databases()
    {
        // Make sure Databases do not exist
        $copySqlite = $this->setupDatabase->copySqlite();
        $this->assertFalse(file_exists($copySqlite));

        $sqliteBase = $this->setupDatabase->baseSqlite();
        $this->assertFalse(file_exists($sqliteBase));

        $this->setupMock();
        app(RefreshDatabase::class)->refreshDatabase();
    }

    public function setupMock()
    {
        $this->partialMock(RefreshDatabase::class, function ($mock) {
            $mock->shouldReceive('refreshDatabase')->andReturn($this->setupDatabase->validateDatabase());
            $mock->shouldReceive('baseSqlite')->andReturn($this->setupDatabase->baseSqlite());
            $mock->shouldReceive('copySqlite')->andReturn($this->setupDatabase->copySqlite());
        });
    }
}