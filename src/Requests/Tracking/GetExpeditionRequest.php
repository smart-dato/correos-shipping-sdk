<?php

namespace SmartDato\CorreosShipping\Requests\Tracking;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\CorreosShipping\Data\Tracking\ExpeditionResponseData;

class GetExpeditionRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $expeditionCode,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/expedition/'.$this->expeditionCode;
    }

    public function createDtoFromResponse(Response $response): ExpeditionResponseData
    {
        return ExpeditionResponseData::from($response->json());
    }
}
