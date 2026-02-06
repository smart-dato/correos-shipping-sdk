<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class GenerateExpeditionResponseData extends Data
{
    /**
     * @param  array<ValidationErrorData>|null  $error
     */
    public function __construct(
        public ?int $result,
        public ?string $shipmentCode,
        public ?string $entryDate,
        #[DataCollectionOf(ValidationErrorData::class)]
        public ?array $error,
    ) {}
}
