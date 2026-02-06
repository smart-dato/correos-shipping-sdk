<?php

namespace SmartDato\CorreosShipping\Data\Labels;

use Spatie\LaravelData\Data;

class LabelsResponseData extends Data
{
    public function __construct(
        public ?string $pdf,
        public ?string $zpl,
        public ?string $xml,
        public ?string $error,
    ) {}
}
