<?php

namespace SmartDato\CorreosShipping;

use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;
use SmartDato\CorreosShipping\Connectors\LabelsConnector;
use SmartDato\CorreosShipping\Connectors\PreregisterConnector;
use SmartDato\CorreosShipping\Connectors\TrackingConnector;
use SmartDato\CorreosShipping\Resources\LabelsResource;
use SmartDato\CorreosShipping\Resources\PreregisterResource;
use SmartDato\CorreosShipping\Resources\TrackingResource;

class CorreosShipping
{
    protected ?PreregisterResource $preregisterResource = null;

    protected ?LabelsResource $labelsResource = null;

    protected ?TrackingResource $trackingResource = null;

    public function __construct(
        protected PreregisterConnector $preregisterConnector,
        protected LabelsConnector $labelsConnector,
        protected TrackingConnector $trackingConnector,
    ) {}

    /**
     * Build an instance manually without the service container.
     *
     * @param  array{
     *     oauth_client_id: string,
     *     oauth_client_secret: string,
     *     token_url?: string,
     *     scope?: string,
     *     gateway_client_id: string,
     *     gateway_client_secret: string,
     *     preregister_url?: string,
     *     labels_url?: string,
     *     tracking_url?: string,
     * }  $config
     */
    public static function make(array $config): self
    {
        $auth = new CorreosAuthenticator(
            oauthClientId: $config['oauth_client_id'],
            oauthClientSecret: $config['oauth_client_secret'],
            tokenUrl: $config['token_url'] ?? 'https://apioauthcid.correos.es/Api/Authorize/Token',
            scope: $config['scope'] ?? 'AP3 LBS RCG',
            gatewayClientId: $config['gateway_client_id'],
            gatewayClientSecret: $config['gateway_client_secret'],
        );

        return new self(
            new PreregisterConnector($auth, $config['preregister_url'] ?? null),
            new LabelsConnector($auth, $config['labels_url'] ?? null),
            new TrackingConnector($auth, $config['tracking_url'] ?? null),
        );
    }

    public function preregister(): PreregisterResource
    {
        return $this->preregisterResource ??= new PreregisterResource($this->preregisterConnector);
    }

    public function labels(): LabelsResource
    {
        return $this->labelsResource ??= new LabelsResource($this->labelsConnector);
    }

    public function tracking(): TrackingResource
    {
        return $this->trackingResource ??= new TrackingResource($this->trackingConnector);
    }
}
