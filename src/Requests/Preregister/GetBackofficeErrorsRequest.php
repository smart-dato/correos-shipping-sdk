<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\CorreosShipping\Data\Preregister\BackofficeResponseData;

class GetBackofficeErrorsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected ?string $contractNumber = null,
        protected ?string $clientNumber = null,
        protected ?string $dateFrom = null,
        protected ?string $dateTo = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/delivery/package/backoffice/error';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'contractNumber' => $this->contractNumber,
            'clientNumber' => $this->clientNumber,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
        ]);
    }

    public function createDtoFromResponse(Response $response): BackofficeResponseData
    {
        return BackofficeResponseData::from($response->json());
    }
}
