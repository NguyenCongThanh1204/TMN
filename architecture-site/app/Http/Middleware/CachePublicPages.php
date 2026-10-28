<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Full-page cache for anonymous public GET pages. It sits after StartSession, so the cookies
 * Laravel adds to the response are never stored and replayed to other visitors.
 */
class CachePublicPages
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->shouldCache($request)) {
            return $next($request);
        }

        $store = Cache::store(config('pagecache.store'));
        $key = $this->cacheKey($request);
        $cached = $store->get($key);

        if (is_array($cached) && isset($cached['content'], $cached['content_type'])) {
            return response($cached['content'], 200, ['Content-Type' => $cached['content_type']])
                ->header('X-Page-Cache', 'HIT');
        }

        $response = $next($request);

        if ($this->isCacheable($response)) {
            $store->put($key, [
                'content' => $response->getContent(),
                'content_type' => $response->headers->get('Content-Type'),
            ], now()->addSeconds((int) config('pagecache.lifetime')));
        }

        return $response->header('X-Page-Cache', 'MISS');
    }

    private function shouldCache(Request $request): bool
    {
        if (! config('pagecache.enabled') || ! $request->isMethod('GET') || $request->ajax() || $request->expectsJson()) {
            return false;
        }

        $prefix = trim((string) config('moonshine.prefix', 'manager'), '/');
        $except = [...config('pagecache.except', []), $prefix, $prefix.'/*'];

        if ($request->is($except)) {
            return false;
        }

        if (array_diff(array_keys($request->query()), config('pagecache.allowed_query', [])) !== []) {
            return false;
        }

        foreach ($request->query() as $value) {
            if (! is_string($value) || strlen($value) > 100) {
                return false;
            }
        }

        return ! auth('moonshine')->check();
    }

    private function isCacheable(Response $response): bool
    {
        return $response->getStatusCode() === 200
            && is_string($response->getContent())
            && str_contains((string) $response->headers->get('Content-Type'), 'text/html')
            && $response->headers->getCookies() === [];
    }

    private function cacheKey(Request $request): string
    {
        $query = $request->query();
        ksort($query);

        return 'page:'.sha1($request->getHost().'|'.$request->getPathInfo().'?'.http_build_query($query));
    }
}
