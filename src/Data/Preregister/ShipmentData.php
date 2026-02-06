<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ShipmentData extends Data
{
    /**
     * @param  array<PackageData>  $packages
     * @param  array<AdditionalValueData>|Optional  $additionalValues
     */
    public function __construct(
        public string $product,
        public string $deliveryMethod,
        public string $contractNumber,
        public string $clientNumber,
        public string $labellerCode,
        public string $packagesNumber,
        public SenderData|Optional $sender,
        public AddresseeData|Optional $addressee,
        #[DataCollectionOf(PackageData::class)]
        public array $packages,
        #[DataCollectionOf(AdditionalValueData::class)]
        public array|Optional $additionalValues,
        public string|Optional $admissionProvince,
        public int|Optional $admissionMethod,
        public string|Optional $manifestCode,
        public string|Optional $totalWeight,
        public string|Optional $totalLength,
        public string|Optional $totalWidth,
        public string|Optional $totalHigh,
        public string|Optional $totalCubicMeters,
        public string|Optional $shipmentCode,
        public string|Optional $shipmentReference1,
        public string|Optional $shipmentReference2,
        public string|Optional $shipmentReference3,
        public string|Optional $shipmentNotes,
        public string|Optional $dateExpiry,
        public string|Optional $modificationType,
        public string|Optional $partialDelivery,
        public string|Optional $dispatchReference,
    ) {}
}
