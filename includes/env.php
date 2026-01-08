<?php
declare(strict_types=1);

$__env = [];

function load_env(string $path): array
{
    $vars = [];
    if (!is_file($path)) {
        return $vars;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key = trim($parts[0]);
        $value = trim($parts[1]);
        if ($value !== '' && $value[0] === '"' && substr($value, -1) === '"') {
            $value = substr($value, 1, -1);
        }
        $vars[$key] = $value;
    }

    return $vars;
}

function env(string $key, ?string $default = null): ?string
{
    global $__env;

    if (!array_key_exists($key, $__env)) {
        $loaded = load_env(__DIR__ . '/../.env');
        $__env = array_merge($__env, $loaded);
    }

    return $__env[$key] ?? $default;
}
