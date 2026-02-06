<?php

namespace SmartDato\CorreosShipping\Data\Tracking;

use Spatie\LaravelData\Data;

class ExpeditionClientData extends Data
{
    public function __construct(
        public ?string $clientCode,
        public ?string $businessName,
        public ?string $typeClient,
        public ?string $address,
        public ?string $locality,
        public ?string $province,
        public ?string $postalCode,
        public ?string $country,
    ) {}
}
