<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class DeliveryResponseData extends Data
{
    /**
     * @param  array<ShipmentResponseData>|null  $shipments
     */
    public function __construct(
        public ?string $fileIdentifier,
        public ?int $result,
        #[DataCollectionOf(ShipmentResponseData::class)]
        public ?array $shipments,
    ) {}
}
