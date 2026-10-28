<?php

return [
    'client' => [
        'connect_timeout' => (int) env('TURSO_CONNECT_TIMEOUT', 5),
        'timeout' => (int) env('TURSO_REQUEST_TIMEOUT', 15),
    ],

    'sync_command' => [
        'node_path' => env('NODE_PATH'),
        'script_filename' => env('TURSO_SYNC_SCRIPT', 'turso-sync.mjs'),
        'script_path' => base_path(),
        'timeout' => 60,
    ],
];
