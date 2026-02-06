<?php

namespace SmartDato\CorreosShipping\Requests\Labels;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\CorreosShipping\Data\Labels\DocumentResponseData;
use SmartDato\CorreosShipping\Data\Labels\PrintDocumentsRequestData;

class PrintDocumentsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected PrintDocumentsRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/documents/print';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): DocumentResponseData
    {
        return DocumentResponseData::from($response->json());
    }
}
