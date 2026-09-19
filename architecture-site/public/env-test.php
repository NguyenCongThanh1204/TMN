<?php

header('Content-Type: text/plain; charset=utf-8');

echo "=== PHP ===\n";
echo "PHP_VERSION: " . PHP_VERSION . "\n";
echo "SAPI: " . PHP_SAPI . "\n\n";

echo "=== ENV COUNT ===\n";
echo "getenv(): " . count(getenv()) . "\n";
echo "_ENV: " . count($_ENV) . "\n";
echo "_SERVER: " . count($_SERVER) . "\n\n";

echo "=== DB TEST ===\n";
echo "DB_CONNECTION getenv: " . (getenv('DB_CONNECTION') ?: 'MISSING') . "\n";
echo "DB_DATABASE getenv: " . (getenv('DB_DATABASE') ?: 'MISSING') . "\n";

echo "\n=== ALL ENV NAMES ===\n";

foreach (array_keys(getenv()) as $key) {
    echo $key . "\n";
}