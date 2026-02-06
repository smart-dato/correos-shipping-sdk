<?php

namespace SmartDato\CorreosShipping\Connectors;

class PreregisterConnector extends CorreosConnector
{
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl ?? config('correos-shipping-sdk.base_urls.preregister');
    }
}
