<?php

namespace SmartDato\CorreosShipping\Data\Labels;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PrintLabelsRequestData extends Data
{
    public function __construct(
        public int $documentationType,
        public PrintData $print,
        public string|Optional $application,
    ) {}
}
