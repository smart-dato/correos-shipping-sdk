<?php

namespace SmartDato\CorreosShipping\Resources;

use SmartDato\CorreosShipping\Connectors\LabelsConnector;
use SmartDato\CorreosShipping\Data\Labels\DocumentBackofficeResponseData;
use SmartDato\CorreosShipping\Data\Labels\DocumentResponseData;
use SmartDato\CorreosShipping\Data\Labels\LabelsResponseData;
use SmartDato\CorreosShipping\Data\Labels\PrintDocumentsRequestData;
use SmartDato\CorreosShipping\Data\Labels\PrintLabelsRequestData;
use SmartDato\CorreosShipping\Requests\Labels\GetDocumentBackofficeRequest;
use SmartDato\CorreosShipping\Requests\Labels\PrintDocumentsRequest;
use SmartDato\CorreosShipping\Requests\Labels\PrintLabelsRequest;

class LabelsResource
{
    protected ?\Saloon\Http\Response $lastResponse = null;

    public function __construct(
        protected LabelsConnector $connector,
    ) {}

    public function lastResponse(): ?\Saloon\Http\Response
    {
        return $this->lastResponse;
    }

    public function printLabels(PrintLabelsRequestData $data): LabelsResponseData
    {
        return ($this->lastResponse = $this->connector->send(new PrintLabelsRequest($data)))->dtoOrFail();
    }

    public function printDocuments(PrintDocumentsRequestData $data): DocumentResponseData
    {
        return ($this->lastResponse = $this->connector->send(new PrintDocumentsRequest($data)))->dtoOrFail();
    }

    public function getDocumentBackoffice(string $shipment): DocumentBackofficeResponseData
    {
        return ($this->lastResponse = $this->connector->send(new GetDocumentBackofficeRequest($shipment)))->dtoOrFail();
    }
}
