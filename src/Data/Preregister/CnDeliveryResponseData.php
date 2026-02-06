<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class CnDeliveryResponseData extends Data
{
    /**
     * @param  array<ShipmentResponseData>|null  $shipments
     */
    public function __construct(
        public ?string $fileIdentifier,
        public ?int $result,
        public ?int $totalShipments,
        #[DataCollectionOf(ShipmentResponseData::class)]
        public ?array $shipments,
    ) {}
}
