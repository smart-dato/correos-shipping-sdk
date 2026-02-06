<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AdditionalValueFieldData extends Data
{
    public function __construct(
        public string $fieldId,
        public string|Optional $value,
    ) {}
}
