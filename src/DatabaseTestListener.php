<?php

namespace BrandonBest\UnittestSqlite;

use BrandonBest\UnittestSqlite\Traits\SetupDatabase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;
use Tests\CreatesApplication;

class DatabaseTestListener implements TestListener
{
    use SetupDatabase;
    use TestListenerDefaultImplementation;
    use CreatesApplication;

    /**
     * Filter out only the feature unit tests
     *
     * @param string $testSuiteName
     *
     * @return bool
     */
    public function isFeatureTestSuite(string $testSuiteName): bool
    {
        return $testSuiteName === 'Feature';
    }

    /**
     * Method runs at the end of each unit test
     *
     * @param TestSuite $testSuite
     */
    public function endTestSuite(TestSuite $testSuite): void
    {
        if (!$this->shouldDeleteBaseSqlite($testSuite)) {
            return;
        }

        echo "\nPackage UnitTest Sqlite: Delete testing databases\n";
        $sqliteFiles = [
            $this->baseSqlite()
        ];

        foreach ($sqliteFiles as $sqliteFile){
            if (file_exists($sqliteFile)) {
                unlink($sqliteFile);
            }
        }
    }

    /**
     * Should we delete the base file?
     *
     * @param TestSuite $testSuite
     *
     * @return bool
     */
    public function shouldDeleteBaseSqlite(TestSuite $testSuite): bool
    {
        $configDeleteBasefile = $this->config('unittest-sqlite.delete_basefile');

        if (!$configDeleteBasefile) {
            return false;
        }

        if ($this->isFeatureTestSuite($testSuite->getName())) {
            return true;
        }

        return false;
    }

    /**
     * Pull the Config Setting
     *
     * @param string $key
     *
     * @return mixed
     */
    public function config(string $key)
    {
        return $this->createApplication()->make('config')->get($key);
    }
}
