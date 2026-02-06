<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\CorreosShipping\Data\Preregister\PackageExpeditionResponseData;

class GetExpeditionPackagesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $expeditionCode,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/delivery/package/expedition/'.$this->expeditionCode;
    }

    public function createDtoFromResponse(Response $response): PackageExpeditionResponseData
    {
        return PackageExpeditionResponseData::from(['packageCodes' => $response->json()]);
    }
}
