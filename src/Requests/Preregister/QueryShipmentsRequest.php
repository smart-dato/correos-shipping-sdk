<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\CorreosShipping\Data\Preregister\QueryRequestData;
use SmartDato\CorreosShipping\Data\Preregister\QueryResponseData;

class QueryShipmentsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected QueryRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/delivery/package';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): QueryResponseData
    {
        return QueryResponseData::from($response->json());
    }
}
