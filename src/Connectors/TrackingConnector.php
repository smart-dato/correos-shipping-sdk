<?php

namespace SmartDato\CorreosShipping\Connectors;

class TrackingConnector extends CorreosConnector
{
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl ?? config('correos-shipping-sdk.base_urls.tracking');
    }
}
