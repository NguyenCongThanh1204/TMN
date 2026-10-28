<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class PageCache
{
    public static function flush(): void
    {
        Cache::store(config('pagecache.store'))->flush();
    }

    /**
     * Waits for the surrounding transaction so a request cannot re-cache stale data
     * between the flush and the commit.
     */
    public static function flushAfterCommit(): void
    {
        DB::afterCommit(static fn () => self::flush());
    }
}
