<?php

namespace SmartDato\CorreosShipping\Connectors;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;
use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;
use SmartDato\CorreosShipping\Exceptions\CorreosApiException;

abstract class CorreosConnector extends Connector
{
    public function __construct(
        protected CorreosAuthenticator $correosAuthenticator,
        protected ?string $baseUrl = null,
        protected bool $verifySsl = true,
        protected ?string $forceIpResolve = null,
    ) {}

    protected function defaultConfig(): array
    {
        $config = [
            'verify' => $this->verifySsl,
        ];

        if ($this->forceIpResolve) {
            $config['force_ip_resolve'] = $this->forceIpResolve;
        }

        return $config;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => 'SmartDato-CorreosShippingSDK/1.0',
        ];
    }

    protected function defaultAuth(): ?Authenticator
    {
        return $this->correosAuthenticator;
    }

    public function getRequestException(\Saloon\Http\Response $response, ?\Throwable $senderException): ?\Throwable
    {
        return CorreosApiException::fromResponse($response);
    }
}
