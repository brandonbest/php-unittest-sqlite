<?php

if (!function_exists('base_path')) {
    function base_path(): string
    {
        $fullPath = dirname(dirname(dirname(dirname(__FILE__))));
        return $fullPath;
    }
}