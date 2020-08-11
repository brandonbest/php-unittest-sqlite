<?php

namespace BrandonBest\UnittestSqlite;

/**
 * This file is part of Prion Development's Membrane Package,
 * an oauth account, role & permission management solution for Lumen.
 *
 * @license MIT
 * @company Prion Development
 * @package Membrane
 */

use Illuminate\Support\Facades\Facade;

class UnittestSqliteFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'unittest-sqlite';
    }
}