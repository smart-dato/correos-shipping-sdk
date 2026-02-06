<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryRequestData;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryResponseData;

class ValidateShipmentsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected DeliveryRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/delivery/validate';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): DeliveryResponseData
    {
        return DeliveryResponseData::from($response->json());
    }
}
