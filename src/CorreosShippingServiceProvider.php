<?php

namespace SmartDato\CorreosShipping;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SmartDato\CorreosShipping\Commands\CorreosShippingCommand;

class CorreosShippingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('correos-shipping-sdk')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_correos_shipping_sdk_table')
            ->hasCommand(CorreosShippingCommand::class);
    }
}
