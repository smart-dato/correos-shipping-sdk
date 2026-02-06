<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AnnulmentRequestData extends Data
{
    public function __construct(
        public string $packageCode,
        public string|Optional $errorCodeLanguage,
    ) {}
}
