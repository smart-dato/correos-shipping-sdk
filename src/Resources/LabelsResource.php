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
    public function __construct(
        protected LabelsConnector $connector,
    ) {}

    public function printLabels(PrintLabelsRequestData $data): LabelsResponseData
    {
        return $this->connector->send(new PrintLabelsRequest($data))->dtoOrFail();
    }

    public function printDocuments(PrintDocumentsRequestData $data): DocumentResponseData
    {
        return $this->connector->send(new PrintDocumentsRequest($data))->dtoOrFail();
    }

    public function getDocumentBackoffice(string $shipment): DocumentBackofficeResponseData
    {
        return $this->connector->send(new GetDocumentBackofficeRequest($shipment))->dtoOrFail();
    }
}
