<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CustomItemData extends Data
{
    public function __construct(
        public string $quantity,
        public string $description,
        public string $netWeight,
        public string $netValue,
        public string|Optional $tariffNumber,
        public string|Optional $countryOrigin,
    ) {}
}
