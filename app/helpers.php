<?php

if (!function_exists('env')) {
    function env(string $key, ?string $defaultValue = null): string
    {
        $value = $_ENV[$key] ?? null;

        return !$value
            ? $defaultValue
            : $value;
    }
}

if (!function_exists('isProd')) {
    function isProd(): bool
    {
        $env = env('APP_ENV', 'local');

        return 'production' === $env;
    }
}

if (!function_exists('root_path')) {
    function root_path(string $path): string
    {
        return __DIR__ ."/../{$path}";
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $path): string
    {
        return __DIR__ ."/../storage/{$path}";
    }
}
