<?php

use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;
use SmartDato\CorreosShipping\Connectors\LabelsConnector;
use SmartDato\CorreosShipping\Connectors\PreregisterConnector;
use SmartDato\CorreosShipping\Connectors\TrackingConnector;

function makeAuthenticator(): CorreosAuthenticator
{
    return new CorreosAuthenticator(
        oauthClientId: 'oauth-id',
        oauthClientSecret: 'oauth-secret',
        tokenUrl: 'https://example.com/token',
        scope: 'AP3 LBS RCG',
        gatewayClientId: 'gateway-id',
        gatewayClientSecret: 'gateway-secret',
    );
}

it('preregister connector resolves correct base url', function () {
    config()->set('correos-shipping-sdk.base_urls.preregister', 'https://api1.correos.es/admissions/preregister/api/v1');

    $connector = new PreregisterConnector(makeAuthenticator());

    expect($connector->resolveBaseUrl())->toBe('https://api1.correos.es/admissions/preregister/api/v1');
});

it('labels connector resolves correct base url', function () {
    config()->set('correos-shipping-sdk.base_urls.labels', 'https://api1.correos.es/support/labels/api/v1');

    $connector = new LabelsConnector(makeAuthenticator());

    expect($connector->resolveBaseUrl())->toBe('https://api1.correos.es/support/labels/api/v1');
});

it('tracking connector resolves correct base url', function () {
    config()->set('correos-shipping-sdk.base_urls.tracking', 'https://api1.correos.es/support/trackpub/api/v2');

    $connector = new TrackingConnector(makeAuthenticator());

    expect($connector->resolveBaseUrl())->toBe('https://api1.correos.es/support/trackpub/api/v2');
});

it('connectors set default json headers', function () {
    $connector = new PreregisterConnector(makeAuthenticator());

    $headers = $connector->headers()->all();

    expect($headers)->toHaveKey('Accept', 'application/json')
        ->toHaveKey('Content-Type', 'application/json');
});
