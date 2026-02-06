<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AnnulmentExpeditionRequestData extends Data
{
    public function __construct(
        public string $expeditionCode,
        public string|Optional $errorCodeLanguage,
    ) {}
}
