<?php

namespace SmartDato\CorreosShipping\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class CorreosAuthenticator implements Authenticator
{
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

    protected function getToken(): string
    {
        return Cache::remember('correos_oauth_token', $this->getTokenTtl(), function () {
            return $this->fetchToken();
        });
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

    protected function getTokenTtl(): int
    {
        return 3300; // 55 minutes (token typically valid for 60 min)
    }
}
