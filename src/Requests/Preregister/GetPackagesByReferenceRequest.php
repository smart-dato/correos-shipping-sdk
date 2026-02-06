<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\CorreosShipping\Data\Preregister\PackageReferenceResponseData;

class GetPackagesByReferenceRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $clientReference,
        protected ?string $contractNumber = null,
        protected ?string $clientNumber = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/delivery/package/reference';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'clientReference' => $this->clientReference,
            'contractNumber' => $this->contractNumber,
            'clientNumber' => $this->clientNumber,
        ]);
    }

    public function createDtoFromResponse(Response $response): PackageReferenceResponseData
    {
        return PackageReferenceResponseData::from(['packageCodes' => $response->json()]);
    }
}
