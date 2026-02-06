<?php

namespace SmartDato\CorreosShipping\Data\Labels;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PrintDocumentsRequestData extends Data
{
    public function __construct(
        public int $documentationType,
        public DocumentDetailData $documentData,
        public string|Optional $application,
    ) {}
}
