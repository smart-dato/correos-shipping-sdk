<?php

namespace SmartDato\CorreosShipping\Data\Labels;

use Spatie\LaravelData\Data;

class DocumentBackofficeResultData extends Data
{
    public function __construct(
        public ?string $entryDate,
        public ?string $shipment,
        public ?string $documentationType,
        public ?string $request,
        public ?string $response,
    ) {}
}
