<?php

namespace SmartDato\CorreosShipping\Data\Labels;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class DocumentDetailData extends Data
{
    public function __construct(
        public string $destinationName,
        public string|Optional $contractNumber,
        public string|Optional $clientNumber,
        public string|Optional $addresseeName,
        public string|Optional $destinationCode,
        public string|Optional $shipmentsNumber,
        public string|Optional $signaturePlace,
        public string|Optional $signatoryDNI,
        public string|Optional $signatoryName,
    ) {}
}
