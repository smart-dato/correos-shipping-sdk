<?php

namespace SmartDato\CorreosShipping\Data\Labels;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class DocumentBackofficeResponseData extends Data
{
    /**
     * @param  array<DocumentBackofficeResultData>|null  $results
     */
    public function __construct(
        #[DataCollectionOf(DocumentBackofficeResultData::class)]
        public ?array $results,
        public ?string $error,
    ) {}
}
