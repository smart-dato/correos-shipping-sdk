<?php

namespace SmartDato\CorreosShipping\Data\Tracking;

use Spatie\LaravelData\Data;

class ExpeditionPackageData extends Data
{
    public function __construct(
        public ?string $shippingCode,
        public ?string $number,
    ) {}
}
