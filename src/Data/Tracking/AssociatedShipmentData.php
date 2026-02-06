<?php

namespace SmartDato\CorreosShipping\Data\Tracking;

use Spatie\LaravelData\Data;

class AssociatedShipmentData extends Data
{
    public function __construct(
        public ?string $shippingCode,
        public ?string $eventDate,
        public ?string $eventHour,
        public ?string $eventCode,
        public ?string $desSummary,
        public ?string $desExtended,
    ) {}
}
