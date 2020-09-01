<?php

namespace BrandonBest\UnittestSqlite\Tests\Unit;

use BrandonBest\UnittestSqlite\Exceptions\UnittestSqliteSetupException;
use BrandonBest\UnittestSqlite\Tests\UnittestSqliteTestCase;
use BrandonBest\UnittestSqlite\Traits\SetupDatabase;

class SetupDatabaseTest extends UnittestSqliteTestCase
{
    /**
     * @var SetupDatabase
     */
    protected $setupDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setupDatabase = new class { use SetupDatabase; };
    }

    public function testIsSqlite()
    {
        config(['database.default' => 'sqlite']);
        $this->assertTrue($this->setupDatabase->isSqlite());

        config(['database.default' => 'mysql']);
        $this->expectException(UnittestSqliteSetupException::class);

        $this->setupDatabase->isSqlite();
    }

}
