<?php

namespace SmartDato\CorreosShipping\Data\Tracking;

use Spatie\LaravelData\Data;

class TrackingEventData extends Data
{
    public function __construct(
        public ?string $eventDate,
        public ?string $eventHours,
        public ?string $eventCode,
        public ?string $eventDes,
        public ?string $phase,
        public ?string $phaseDes,
        public ?string $color,
        public ?string $summaryText,
        public ?string $expandedText,
        public ?string $unit,
        public ?string $location,
        public ?string $province,
        public ?string $country,
        public ?string $coordinateX,
        public ?string $coordinateY,
    ) {}
}
