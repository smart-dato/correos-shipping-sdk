<?php

namespace SmartDato\CorreosShipping\Requests\Preregister;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\CorreosShipping\Data\Preregister\LabelsInfoResponseData;
use SmartDato\CorreosShipping\Data\Preregister\SearchLabelsInfoRequestData;

class SearchLabelsInfoRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected SearchLabelsInfoRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/labels/info/search';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): LabelsInfoResponseData
    {
        return LabelsInfoResponseData::from($response->json());
    }
}
