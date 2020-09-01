<?php

namespace BrandonBest\UnittestSqlite\Tests;

abstract class UnittestSqliteTestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the Provider on Unit Tests
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'BrandonBest\UnittestSqlite\UnittestSqliteServiceProvider'
        ];
    }
}
