<?php

return [
    'enabled' => (bool) env('PAGE_CACHE_ENABLED', true),

    // Dedicated file store (config/cache.php) so cache hits never touch Turso.
    'store' => 'responsecache',

    'lifetime' => (int) env('PAGE_CACHE_LIFETIME', 86400),

    // Requests with any other query key are served live, which keeps arbitrary
    // URLs (e.g. ?search=...) from filling the cache.
    'allowed_query' => ['page', 'category'],

    // Path patterns (Request::is) that are never cached. The MoonShine prefix is always excluded.
    'except' => ['up'],
];
