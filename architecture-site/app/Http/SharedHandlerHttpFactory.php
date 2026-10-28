<?php

declare(strict_types=1);

namespace App\Http;

use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Handler\StreamHandler;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;

/**
 * Every Http:: call builds a new Guzzle client, and with it a new cURL handle, so each
 * request to Turso paid a full DNS + TCP + TLS handshake. Sharing one handler keeps the
 * cURL handle cache (and its open connections) alive for the whole PHP process.
 */
class SharedHandlerHttpFactory extends Factory
{
    private static mixed $sharedHandler = null;

    protected function newPendingRequest(): PendingRequest
    {
        $request = parent::newPendingRequest();

        return $request->setHandler(self::sharedHandler());
    }

    private static function sharedHandler(): callable
    {
        return self::$sharedHandler ??= extension_loaded('curl')
            ? new CurlHandler
            : new StreamHandler;
    }
}
