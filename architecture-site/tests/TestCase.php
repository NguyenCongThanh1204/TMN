<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    public function createApplication(): Application
    {
        $app = parent::createApplication();

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
        $app['config']->set('database.connections.sqlite.url', null);

        $database = $app->make('db');
        $database->setDefaultConnection('sqlite');
        $database->purge('sqlite');

        if ($database->connection()->getDriverName() !== 'sqlite') {
            throw new RuntimeException('Tests must use an isolated SQLite database.');
        }

        return $app;
    }
}
