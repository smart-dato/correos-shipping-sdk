<?php

namespace SmartDato\CorreosShipping\Data\Tracking;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class ShipmentSearchResponseData extends Data
{
    /**
     * @param  array<TrackingEventData>|null  $events
     * @param  array<ContentsData>|null  $contents
     * @param  array<CustomsData>|null  $data_customs
     * @param  array<AssociatedShipmentData>|null  $associatedShipments
     * @param  array<TrackingErrorData>|null  $error
     */
    public function __construct(
        public ?string $code,
        public ?string $clientCode,
        public ?string $clientName,
        public ?string $relationshipCode,
        public ?string $serviceCode,
        public ?string $serviceTypeCode,
        public ?string $serviceDate,
        public ?string $codProduct,
        public ?string $shipmentType,
        public ?string $reference1,
        public ?string $reference2,
        public ?string $reference3,
        public ?string $refClient,
        public ?string $remitName,
        public ?string $remitNameLane,
        public ?string $remitPostalCode,
        public ?string $remitNameLocation,
        public ?string $remitNameProvince,
        public ?string $remitPhone,
        public ?string $remitEmail,
        public ?string $remitDoi,
        public ?string $destiName,
        public ?string $destiNameLane,
        public ?string $destiPostalCode,
        public ?string $destiNameLocation,
        public ?string $destiNameProvince,
        public ?string $destiPhone,
        public ?string $destiEmail,
        public ?string $receiverName,
        public ?string $receiverNameLane,
        public ?string $receiverPostalCode,
        public ?string $receiverNameLocation,
        public ?string $receiverNameProvince,
        public ?string $receiverPhone,
        public ?string $receiverEmail,
        public ?string $receiverBusinessName,
        public ?string $receiverRelationship,
        public ?string $totalPackage,
        public ?string $weight,
        public ?string $height,
        public ?string $width,
        public ?string $length,
        #[DataCollectionOf(TrackingEventData::class)]
        public ?array $events,
        #[DataCollectionOf(ContentsData::class)]
        public ?array $contents,
        #[DataCollectionOf(CustomsData::class)]
        public ?array $data_customs,
        #[DataCollectionOf(AssociatedShipmentData::class)]
        public ?array $associatedShipments,
        #[DataCollectionOf(TrackingErrorData::class)]
        public ?array $error,
    ) {}
}
