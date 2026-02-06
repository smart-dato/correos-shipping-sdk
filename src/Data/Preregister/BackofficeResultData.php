<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;

class BackofficeResultData extends Data
{
    public function __construct(
        public ?string $entryDate,
        public ?string $operation,
        public ?string $request,
        public ?string $response,
    ) {}
}
