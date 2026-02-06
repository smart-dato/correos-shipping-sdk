<?php

namespace SmartDato\CorreosShipping\Requests\Tracking;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\CorreosShipping\Data\Tracking\ShipmentSearchResponseData;

class SearchShipmentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $shippingCode,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/search/'.$this->shippingCode;
    }

    public function createDtoFromResponse(Response $response): ShipmentSearchResponseData
    {
        return ShipmentSearchResponseData::from($response->json());
    }
}
