<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class DeliveryRequestData extends Data
{
    /**
     * @param  array<ShipmentData>  $shipments
     */
    public function __construct(
        #[DataCollectionOf(ShipmentData::class)]
        public array $shipments,
        public string|Optional $errorCodeLanguage,
    ) {}
}
