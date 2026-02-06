<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PackageData extends Data
{
    /**
     * @param  array<AdditionalValueData>|Optional  $packageAdditionalValues
     */
    public function __construct(
        public string|Optional $packageId,
        public string $packageWeightGrams,
        public string|Optional $packageHeight,
        public string|Optional $packageWidth,
        public string|Optional $packageLength,
        public string|Optional $cubicMeters,
        public string|Optional $packageCode,
        public string|Optional $clientReference,
        public string|Optional $clientReference2,
        public string|Optional $clientReference3,
        public string|Optional $observations,
        public string|Optional $packingIndicator,
        public string|Optional $associatedOneWayPackageCode,
        public string|Optional $imeiID,
        public string|Optional $temperatureTraceabilityID,
        public string|Optional $temperatureRangeID,
        public string|Optional $dataLoggerID,
        public string|Optional $prepareReturnShippingIndicator,
        public PackageContentsData|Optional $packageContents,
        #[DataCollectionOf(AdditionalValueData::class)]
        public array|Optional $packageAdditionalValues,
    ) {}
}
