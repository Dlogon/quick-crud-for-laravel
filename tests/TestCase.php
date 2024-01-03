<?php

namespace Dlogon\QuickCrudForLaravel\Tests;

use Dlogon\QuickCrudForLaravel\QuickCrudForLaravelServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Dlogon\\QuickCrudForLaravel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            QuickCrudForLaravelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_quick-crud-for-laravel_table.php.stub';
        $migration->up();
        */
    }
}
