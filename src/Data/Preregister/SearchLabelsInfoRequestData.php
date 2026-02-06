<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SearchLabelsInfoRequestData extends Data
{
    public function __construct(
        public string|Optional $labellerCode,
        public string|Optional $contractNumber,
        public string|Optional $clientNumber,
        public string|Optional $clientName,
        public string|Optional $doiNumber,
        public string|Optional $anexoCodes,
    ) {}
}
