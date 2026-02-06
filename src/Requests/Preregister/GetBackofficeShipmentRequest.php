<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\CorreosShipping\Data\Preregister\BackofficeResponseData;

class GetBackofficeShipmentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $shipmentCode,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/delivery/package/backoffice/shipment/'.$this->shipmentCode;
    }

    public function createDtoFromResponse(Response $response): BackofficeResponseData
    {
        return BackofficeResponseData::from($response->json());
    }
}
