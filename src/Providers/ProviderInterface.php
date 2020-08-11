<?php

namespace BrandonBest\UnittestSqlite\Providers;

interface ProviderInterface
{
    public function boot(): void;

    public function register(): void;
}
