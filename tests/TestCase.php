<?php

namespace Dlogon\QuickCrudForLaravel\Tests;

use Dlogon\QuickCrudForLaravel\Database\Seeders\DatabaseSeeder;
use Dlogon\QuickCrudForLaravel\QuickCrudForLaravelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
        $this->seed(DatabaseSeeder::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            QuickCrudForLaravelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
