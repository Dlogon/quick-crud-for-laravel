<?php

namespace Dlogon\QuickCrudForLaravel;

use Dlogon\QuickCrudForLaravel\Commands\CreateResourceControllerCommand;
use Dlogon\QuickCrudForLaravel\Commands\CreateViewsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class QuickCrudForLaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('quick-crud-for-laravel')
            ->hasConfigFile()
            ->hasViews()
            //->hasMigration('create_quick-crud-for-laravel_table')
            ->hasCommands(CreateResourceControllerCommand::class,
                CreateViewsCommand::class);

    }
}
