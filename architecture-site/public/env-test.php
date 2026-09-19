<?php

header('Content-Type: text/plain; charset=utf-8');

$keys = [
    'APP_ENV',
    'APP_DEBUG',
    'APP_URL',
    'APP_KEY',
    'DB_CONNECTION',
    'DB_DATABASE',
];

echo "=== getenv() ===\n";

foreach ($keys as $key) {
    $value = getenv($key);

    if ($key === 'APP_KEY') {
        echo $key . ': ' . ($value !== false && $value !== '' ? 'SET' : 'MISSING') . "\n";
    } else {
        echo $key . ': ' . ($value === false ? 'MISSING' : $value) . "\n";
    }
}

echo "\n=== _ENV ===\n";

foreach ($keys as $key) {
    $value = $_ENV[$key] ?? null;

    if ($key === 'APP_KEY') {
        echo $key . ': ' . ($value ? 'SET' : 'MISSING') . "\n";
    } else {
        echo $key . ': ' . ($value === null ? 'MISSING' : $value) . "\n";
    }
}

echo "\n=== _SERVER ===\n";

foreach ($keys as $key) {
    $value = $_SERVER[$key] ?? null;

    if ($key === 'APP_KEY') {
        echo $key . ': ' . ($value ? 'SET' : 'MISSING') . "\n";
    } else {
        echo $key . ': ' . ($value === null ? 'MISSING' : $value) . "\n";
    }
}