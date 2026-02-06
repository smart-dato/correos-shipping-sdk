<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class ShipmentResponseData extends Data
{
    /**
     * @param  array<PackageResponseData>|null  $packages
     * @param  array<ValidationErrorData>|null  $error
     */
    public function __construct(
        public ?int $validationErrorCount,
        public ?string $shipmentCode,
        public ?string $entryDate,
        #[DataCollectionOf(PackageResponseData::class)]
        public ?array $packages,
        #[DataCollectionOf(ValidationErrorData::class)]
        public ?array $error,
    ) {}
}
