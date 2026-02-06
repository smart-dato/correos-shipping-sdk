<?php

namespace SmartDato\CorreosShipping\Data\Labels;

use Spatie\LaravelData\Data;

class DocumentResponseData extends Data
{
    public function __construct(
        public ?string $pdf,
        public ?string $error,
    ) {}
}
