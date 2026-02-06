<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class QueryShipmentResponseData extends Data
{
    /**
     * @param  array<PackageResponseData>|null  $packages
     * @param  array<ValidationErrorData>|null  $error
     */
    public function __construct(
        public ?string $shipmentCode,
        public ?string $product,
        public ?string $deliveryMethod,
        public ?string $contractNumber,
        public ?string $clientNumber,
        public ?string $labellerCode,
        public ?string $packagesNumber,
        public ?string $entryDate,
        public ?SenderData $sender,
        public ?AddresseeData $addressee,
        #[DataCollectionOf(PackageResponseData::class)]
        public ?array $packages,
        #[DataCollectionOf(ValidationErrorData::class)]
        public ?array $error,
    ) {}
}
