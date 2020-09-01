<?php

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return local_base_path($path);
    }
}

if (!function_exists('local_base_path')) {
    /**
     * Determine the Base Directory Locally
     *
     * @param string $path
     *
     * @return string
     */
    function local_base_path(string $path = ''): string
    {
        $fullPath = dirname(__FILE__);

        $fullPath .= '/' . $path;
        $fullPath = str_replace('//', '/', $fullPath);
        return $fullPath;
    }
}
