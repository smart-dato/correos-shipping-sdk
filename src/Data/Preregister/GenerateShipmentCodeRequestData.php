<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class GenerateShipmentCodeRequestData extends Data
{
    public function __construct(
        public string $contractNumber,
        public string $clientNumber,
        public string $labellerCode,
        public string $packagesNumber,
        public string $product,
        public string $deliveryMethod,
        public string|Optional $frankingType,
    ) {}
}
