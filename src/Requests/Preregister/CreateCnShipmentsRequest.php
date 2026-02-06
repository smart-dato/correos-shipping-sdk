<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\CorreosShipping\Data\Preregister\CnDeliveryResponseData;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryRequestData;

class CreateCnShipmentsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected DeliveryRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/delivery/cn';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): CnDeliveryResponseData
    {
        return CnDeliveryResponseData::from($response->json());
    }
}
