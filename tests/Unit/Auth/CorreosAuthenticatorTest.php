<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Saloon\Contracts\Authenticator;
use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;

function fakeCorreosJwt(array $claims): string
{
    $encode = fn (array $data) => rtrim(strtr(base64_encode(json_encode($data)), '+/', '-_'), '=');

    return $encode(['alg' => 'RS256', 'typ' => 'JWT']).'.'.$encode($claims).'.signature';
}

function testableAuthenticator(): CorreosAuthenticator
{
    return new class(oauthClientId: 'oauth-id', oauthClientSecret: 'oauth-secret', tokenUrl: 'https://example.com/token', scope: 'AP3 LBS RCG', gatewayClientId: 'gateway-id', gatewayClientSecret: 'gateway-secret') extends CorreosAuthenticator
    {
        public function exposedGetToken(): string
        {
            return $this->getToken();
        }

        public function exposedGetTokenTtl(string $token): int
        {
            return $this->getTokenTtl($token);
        }
    };
}

it('sets authorization and gateway headers on pending request', function () {
    $authenticator = new CorreosAuthenticator(
        oauthClientId: 'oauth-id',
        oauthClientSecret: 'oauth-secret',
        tokenUrl: 'https://example.com/token',
        scope: 'AP3 LBS RCG',
        gatewayClientId: 'gateway-id',
        gatewayClientSecret: 'gateway-secret',
    );

    expect($authenticator)->toBeInstanceOf(Authenticator::class);
});

it('derives the cache ttl from the jwt exp claim minus a safety buffer', function () {
    $token = fakeCorreosJwt(['exp' => time() + 1800]);

    $ttl = testableAuthenticator()->exposedGetTokenTtl($token);

    expect($ttl)->toBeGreaterThan(1730)
        ->and($ttl)->toBeLessThanOrEqual(1740);
});

it('returns a zero ttl for an already expired token', function () {
    $token = fakeCorreosJwt(['exp' => time() - 10]);

    expect(testableAuthenticator()->exposedGetTokenTtl($token))->toBe(0);
});

it('falls back to a conservative ttl when the token is not a parseable jwt', function () {
    expect(testableAuthenticator()->exposedGetTokenTtl('opaque-token'))->toBe(1500);
});

it('falls back to a conservative ttl when the jwt has no exp claim', function () {
    $token = fakeCorreosJwt(['iss' => 'CID']);

    expect(testableAuthenticator()->exposedGetTokenTtl($token))->toBe(1500);
});

it('caches the fetched token and reuses it on subsequent calls', function () {
    Cache::flush();

    $token = fakeCorreosJwt(['exp' => time() + 1800]);

    Http::fake([
        'example.com/token' => Http::response([
            'idToken' => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => 30,
        ]),
    ]);

    $authenticator = testableAuthenticator();

    expect($authenticator->exposedGetToken())->toBe($token)
        ->and($authenticator->exposedGetToken())->toBe($token)
        ->and(Cache::get($authenticator->cacheKey()))->toBe($token);

    Http::assertSentCount(1);
});

it('caches tokens per account', function () {
    $accountOne = new CorreosAuthenticator('id-one', 'secret-one', 'https://example.com/token', 'AP3', 'gw-id', 'gw-secret');
    $accountTwo = new CorreosAuthenticator('id-two', 'secret-two', 'https://example.com/token', 'AP3', 'gw-id', 'gw-secret');
    $accountOneOnPre = new CorreosAuthenticator('id-one', 'secret-one', 'https://pre.example.com/token', 'AP3', 'gw-id', 'gw-secret');

    expect($accountOne->cacheKey())->not->toBe($accountTwo->cacheKey())
        ->and($accountOne->cacheKey())->not->toBe($accountOneOnPre->cacheKey());
});

it('does not cache a token that is about to expire', function () {
    Cache::flush();

    $token = fakeCorreosJwt(['exp' => time() + 30]);

    Http::fake([
        'example.com/token' => Http::response([
            'idToken' => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => 30,
        ]),
    ]);

    $authenticator = testableAuthenticator();

    expect($authenticator->exposedGetToken())->toBe($token)
        ->and(Cache::get($authenticator->cacheKey()))->toBeNull();
});
