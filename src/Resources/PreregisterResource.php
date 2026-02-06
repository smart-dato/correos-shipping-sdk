<?php

namespace SmartDato\CorreosShipping\Resources;

use SmartDato\CorreosShipping\Connectors\PreregisterConnector;
use SmartDato\CorreosShipping\Data\Preregister\AnnulmentExpeditionRequestData;
use SmartDato\CorreosShipping\Data\Preregister\AnnulmentRequestData;
use SmartDato\CorreosShipping\Data\Preregister\AnnulmentResponseData;
use SmartDato\CorreosShipping\Data\Preregister\BackofficeResponseData;
use SmartDato\CorreosShipping\Data\Preregister\CnDeliveryResponseData;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryRequestData;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryResponseData;
use SmartDato\CorreosShipping\Data\Preregister\GenerateExpeditionResponseData;
use SmartDato\CorreosShipping\Data\Preregister\GenerateShipmentCodeRequestData;
use SmartDato\CorreosShipping\Data\Preregister\LabelsInfoResponseData;
use SmartDato\CorreosShipping\Data\Preregister\ModifyResponseData;
use SmartDato\CorreosShipping\Data\Preregister\PackageExpeditionResponseData;
use SmartDato\CorreosShipping\Data\Preregister\PackageReferenceResponseData;
use SmartDato\CorreosShipping\Data\Preregister\QueryRequestData;
use SmartDato\CorreosShipping\Data\Preregister\QueryResponseData;
use SmartDato\CorreosShipping\Data\Preregister\SearchLabelsInfoRequestData;
use SmartDato\CorreosShipping\Requests\Preregister\CancelExpeditionRequest;
use SmartDato\CorreosShipping\Requests\Preregister\CancelShipmentRequest;
use SmartDato\CorreosShipping\Requests\Preregister\CreateCnShipmentsRequest;
use SmartDato\CorreosShipping\Requests\Preregister\CreateShipmentsRequest;
use SmartDato\CorreosShipping\Requests\Preregister\GenerateShipmentCodeRequest;
use SmartDato\CorreosShipping\Requests\Preregister\GetBackofficeErrorsRequest;
use SmartDato\CorreosShipping\Requests\Preregister\GetBackofficeShipmentRequest;
use SmartDato\CorreosShipping\Requests\Preregister\GetBackofficeTotalRequest;
use SmartDato\CorreosShipping\Requests\Preregister\GetBackofficeWaitingRequest;
use SmartDato\CorreosShipping\Requests\Preregister\GetExpeditionPackagesRequest;
use SmartDato\CorreosShipping\Requests\Preregister\GetPackagesByReferenceRequest;
use SmartDato\CorreosShipping\Requests\Preregister\ModifyShipmentRequest;
use SmartDato\CorreosShipping\Requests\Preregister\QueryShipmentsIrisRequest;
use SmartDato\CorreosShipping\Requests\Preregister\QueryShipmentsRequest;
use SmartDato\CorreosShipping\Requests\Preregister\SearchLabelsInfoRequest;
use SmartDato\CorreosShipping\Requests\Preregister\ValidateShipmentsRequest;

class PreregisterResource
{
    protected ?\Saloon\Http\Response $lastResponse = null;

    public function __construct(
        protected PreregisterConnector $connector,
    ) {}

    public function lastResponse(): ?\Saloon\Http\Response
    {
        return $this->lastResponse;
    }

    public function validateShipments(DeliveryRequestData $data): DeliveryResponseData
    {
        return ($this->lastResponse = $this->connector->send(new ValidateShipmentsRequest($data)))->dtoOrFail();
    }

    public function createShipments(DeliveryRequestData $data): DeliveryResponseData
    {
        return ($this->lastResponse = $this->connector->send(new CreateShipmentsRequest($data)))->dtoOrFail();
    }

    public function createCnShipments(DeliveryRequestData $data): CnDeliveryResponseData
    {
        return ($this->lastResponse = $this->connector->send(new CreateCnShipmentsRequest($data)))->dtoOrFail();
    }

    public function queryShipments(QueryRequestData $data): QueryResponseData
    {
        return ($this->lastResponse = $this->connector->send(new QueryShipmentsRequest($data)))->dtoOrFail();
    }

    public function queryShipmentsIris(QueryRequestData $data): QueryResponseData
    {
        return ($this->lastResponse = $this->connector->send(new QueryShipmentsIrisRequest($data)))->dtoOrFail();
    }

    public function modifyShipment(DeliveryRequestData $data): ModifyResponseData
    {
        return ($this->lastResponse = $this->connector->send(new ModifyShipmentRequest($data)))->dtoOrFail();
    }

    public function cancelShipment(AnnulmentRequestData $data): AnnulmentResponseData
    {
        return ($this->lastResponse = $this->connector->send(new CancelShipmentRequest($data)))->dtoOrFail();
    }

    public function cancelExpedition(AnnulmentExpeditionRequestData $data): AnnulmentResponseData
    {
        return ($this->lastResponse = $this->connector->send(new CancelExpeditionRequest($data)))->dtoOrFail();
    }

    public function generateShipmentCode(GenerateShipmentCodeRequestData $data): GenerateExpeditionResponseData
    {
        return ($this->lastResponse = $this->connector->send(new GenerateShipmentCodeRequest($data)))->dtoOrFail();
    }

    public function getExpeditionPackages(string $expeditionCode): PackageExpeditionResponseData
    {
        return ($this->lastResponse = $this->connector->send(new GetExpeditionPackagesRequest($expeditionCode)))->dtoOrFail();
    }

    public function getPackagesByReference(string $clientReference, ?string $contractNumber = null, ?string $clientNumber = null): PackageReferenceResponseData
    {
        return ($this->lastResponse = $this->connector->send(new GetPackagesByReferenceRequest($clientReference, $contractNumber, $clientNumber)))->dtoOrFail();
    }

    public function searchLabelsInfo(SearchLabelsInfoRequestData $data): LabelsInfoResponseData
    {
        return ($this->lastResponse = $this->connector->send(new SearchLabelsInfoRequest($data)))->dtoOrFail();
    }

    public function getBackofficeShipment(string $shipmentCode): BackofficeResponseData
    {
        return ($this->lastResponse = $this->connector->send(new GetBackofficeShipmentRequest($shipmentCode)))->dtoOrFail();
    }

    public function getBackofficeErrors(?string $contractNumber = null, ?string $clientNumber = null, ?string $dateFrom = null, ?string $dateTo = null): BackofficeResponseData
    {
        return ($this->lastResponse = $this->connector->send(new GetBackofficeErrorsRequest($contractNumber, $clientNumber, $dateFrom, $dateTo)))->dtoOrFail();
    }

    public function getBackofficeTotal(?string $contractNumber = null, ?string $clientNumber = null, ?string $dateFrom = null, ?string $dateTo = null): BackofficeResponseData
    {
        return ($this->lastResponse = $this->connector->send(new GetBackofficeTotalRequest($contractNumber, $clientNumber, $dateFrom, $dateTo)))->dtoOrFail();
    }

    public function getBackofficeWaiting(?string $contractNumber = null, ?string $clientNumber = null, ?string $dateFrom = null, ?string $dateTo = null): BackofficeResponseData
    {
        return ($this->lastResponse = $this->connector->send(new GetBackofficeWaitingRequest($contractNumber, $clientNumber, $dateFrom, $dateTo)))->dtoOrFail();
    }
}
