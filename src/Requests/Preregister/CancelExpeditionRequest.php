<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\CorreosShipping\Data\Preregister\AnnulmentExpeditionRequestData;
use SmartDato\CorreosShipping\Data\Preregister\AnnulmentResponseData;

class CancelExpeditionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected AnnulmentExpeditionRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/delivery/annulment/expedition';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): AnnulmentResponseData
    {
        return AnnulmentResponseData::from($response->json());
    }
}
