<?php

namespace SmartDato\CorreosShipping\Resources;

use SmartDato\CorreosShipping\Connectors\TrackingConnector;
use SmartDato\CorreosShipping\Data\Tracking\ExpeditionResponseData;
use SmartDato\CorreosShipping\Data\Tracking\ShipmentSearchResponseData;
use SmartDato\CorreosShipping\Requests\Tracking\GetExpeditionRequest;
use SmartDato\CorreosShipping\Requests\Tracking\SearchShipmentRequest;

class TrackingResource
{
    public function __construct(
        protected TrackingConnector $connector,
    ) {}

    public function searchShipment(string $shippingCode): ShipmentSearchResponseData
    {
        return $this->connector->send(new SearchShipmentRequest($shippingCode))->dtoOrFail();
    }

    public function getExpedition(string $expeditionCode): ExpeditionResponseData
    {
        return $this->connector->send(new GetExpeditionRequest($expeditionCode))->dtoOrFail();
    }
}
