<?php

namespace SmartDato\CorreosShipping\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class CorreosAuthenticator implements Authenticator
{
    protected const CACHE_KEY_PREFIX = 'correos_oauth_token';

    protected const EXPIRY_BUFFER_SECONDS = 60;

    protected const FALLBACK_TTL_SECONDS = 1500;

    public function __construct(
        protected string $oauthClientId,
        protected string $oauthClientSecret,
        protected string $tokenUrl,
        protected string $scope,
        protected string $gatewayClientId,
        protected string $gatewayClientSecret,
        protected bool $verifySsl = true,
        protected ?string $forceIpResolve = null,
    ) {}

    public function set(PendingRequest $pendingRequest): void
    {
        $token = $this->getToken();

        $pendingRequest->headers()->add('Authorization', 'Bearer '.$token);
        $pendingRequest->headers()->add('client_id', $this->gatewayClientId);
        $pendingRequest->headers()->add('client_secret', $this->gatewayClientSecret);
    }

    public function cacheKey(): string
    {
        $accountHash = md5(implode('|', [
            $this->tokenUrl,
            $this->oauthClientId,
            $this->oauthClientSecret,
            $this->scope,
        ]));

        return self::CACHE_KEY_PREFIX.':'.$accountHash;
    }

    protected function getToken(): string
    {
        $cachedToken = Cache::get($this->cacheKey());

        if ($cachedToken) {
            return $cachedToken;
        }

        $token = $this->fetchToken();

        Cache::put($this->cacheKey(), $token, $this->getTokenTtl($token));

        return $token;
    }

    protected function fetchToken(): string
    {
        $options = ['verify' => $this->verifySsl];
        if ($this->forceIpResolve) {
            $options['force_ip_resolve'] = $this->forceIpResolve;
        }

        $response = Http::asForm()->withOptions($options)->post($this->tokenUrl, [
            'grant_type' => 'client_credentials',
            'client_id' => $this->oauthClientId,
            'client_secret' => $this->oauthClientSecret,
            'scope' => $this->scope,
        ]);

        $response->throw();

        return $response->json('idToken');
    }

    /**
     * The token lifetime varies per environment (30 min observed on production),
     * so the TTL is derived from the JWT `exp` claim instead of a fixed value.
     */
    protected function getTokenTtl(string $token): int
    {
        $expiresAt = $this->resolveJwtExpiry($token);

        if (! $expiresAt) {
            return self::FALLBACK_TTL_SECONDS;
        }

        return max($expiresAt - time() - self::EXPIRY_BUFFER_SECONDS, 0);
    }

    protected function resolveJwtExpiry(string $token): ?int
    {
        $segments = explode('.', $token);

        if (count($segments) !== 3) {
            return null;
        }

        $payload = json_decode(base64_decode(strtr($segments[1], '-_', '+/')), true);

        if (! is_array($payload)) {
            return null;
        }

        $expiry = $payload['exp'] ?? null;

        if (! is_numeric($expiry)) {
            return null;
        }

        return (int) $expiry;
    }
}
