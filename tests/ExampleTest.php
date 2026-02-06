<?php

use SmartDato\CorreosShipping\CorreosShipping;

it('can resolve correos shipping from container', function () {
    config()->set('correos-shipping-sdk.oauth.client_id', 'test');
    config()->set('correos-shipping-sdk.oauth.client_secret', 'test');
    config()->set('correos-shipping-sdk.oauth.token_url', 'https://example.com/token');
    config()->set('correos-shipping-sdk.oauth.scope', 'AP3 LBS RCG');
    config()->set('correos-shipping-sdk.gateway.client_id', 'test');
    config()->set('correos-shipping-sdk.gateway.client_secret', 'test');

    $correos = app(CorreosShipping::class);

    expect($correos)->toBeInstanceOf(CorreosShipping::class);
});
