<?php

namespace SmartDato\CorreosShipping\Data\Tracking;

use Spatie\LaravelData\Data;

class CustomsData extends Data
{
    public function __construct(
        public ?string $color,
        public ?string $description,
    ) {}
}
