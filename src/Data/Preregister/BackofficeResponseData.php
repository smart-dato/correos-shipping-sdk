<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class BackofficeResponseData extends Data
{
    /**
     * @param  array<BackofficeResultData>|null  $results
     */
    public function __construct(
        public ?string $entryDate,
        #[DataCollectionOf(BackofficeResultData::class)]
        public ?array $results,
        public ?string $error,
    ) {}
}
