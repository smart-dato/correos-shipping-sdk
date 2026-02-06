<?php

namespace SmartDato\CorreosShipping;

use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;
use SmartDato\CorreosShipping\Connectors\LabelsConnector;
use SmartDato\CorreosShipping\Connectors\PreregisterConnector;
use SmartDato\CorreosShipping\Connectors\TrackingConnector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CorreosShippingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('correos-shipping-sdk')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(CorreosAuthenticator::class, function () {
            return new CorreosAuthenticator(
                oauthClientId: (string) config('correos-shipping-sdk.oauth.client_id'),
                oauthClientSecret: (string) config('correos-shipping-sdk.oauth.client_secret'),
                tokenUrl: (string) config('correos-shipping-sdk.oauth.token_url'),
                scope: (string) config('correos-shipping-sdk.oauth.scope'),
                gatewayClientId: (string) config('correos-shipping-sdk.gateway.client_id'),
                gatewayClientSecret: (string) config('correos-shipping-sdk.gateway.client_secret'),
            );
        });

        $this->app->singleton(PreregisterConnector::class, function ($app) {
            return new PreregisterConnector($app->make(CorreosAuthenticator::class));
        });

        $this->app->singleton(LabelsConnector::class, function ($app) {
            return new LabelsConnector($app->make(CorreosAuthenticator::class));
        });

        $this->app->singleton(TrackingConnector::class, function ($app) {
            return new TrackingConnector($app->make(CorreosAuthenticator::class));
        });

        $this->app->singleton(CorreosShipping::class, function ($app) {
            return new CorreosShipping(
                $app->make(PreregisterConnector::class),
                $app->make(LabelsConnector::class),
                $app->make(TrackingConnector::class),
            );
        });
    }
}
