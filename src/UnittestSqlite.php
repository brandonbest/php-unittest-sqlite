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

class UnittestSqlite
{
    /**
     * Laravel application.
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }
}