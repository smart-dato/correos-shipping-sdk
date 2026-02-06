<?php

use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;

it('sets authorization and gateway headers on pending request', function () {
    $authenticator = new CorreosAuthenticator(
        oauthClientId: 'oauth-id',
        oauthClientSecret: 'oauth-secret',
        tokenUrl: 'https://example.com/token',
        scope: 'AP3 LBS RCG',
        gatewayClientId: 'gateway-id',
        gatewayClientSecret: 'gateway-secret',
    );

    expect($authenticator)->toBeInstanceOf(\Saloon\Contracts\Authenticator::class);
});
