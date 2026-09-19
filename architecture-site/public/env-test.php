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

foreach ($keys as $key) {
    $value = getenv($key);

    if ($key === 'APP_KEY') {
        echo $key . ': ' . ($value !== false && $value !== '' ? 'SET' : 'MISSING') . "\n";
    } else {
        echo $key . ': ' . ($value === false ? 'MISSING' : $value) . "\n";
    }
}