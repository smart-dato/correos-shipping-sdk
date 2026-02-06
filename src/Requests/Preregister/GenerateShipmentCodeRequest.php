<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\CorreosShipping\Data\Preregister\GenerateExpeditionResponseData;
use SmartDato\CorreosShipping\Data\Preregister\GenerateShipmentCodeRequestData;

class GenerateShipmentCodeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected GenerateShipmentCodeRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/generate/shipmentcode';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): GenerateExpeditionResponseData
    {
        return GenerateExpeditionResponseData::from($response->json());
    }
}
