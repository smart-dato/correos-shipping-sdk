<?php

namespace SmartDato\CorreosShipping\Data\Tracking;

use Spatie\LaravelData\Data;

class ContentsData extends Data
{
    public function __construct(
        public ?string $tarifario,
        public ?string $shipmentNature,
        public ?string $netWeight,
        public ?string $netWorth,
        public ?string $merchandiseCode,
        public ?string $merchandise,
        public ?string $amount,
    ) {}
}
