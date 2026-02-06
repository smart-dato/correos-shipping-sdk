<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;

class LabelsInfoResponseData extends Data
{
    /**
     * @param  array<mixed>|null  $results
     */
    public function __construct(
        public ?array $results,
        public ?string $error,
    ) {}
}
