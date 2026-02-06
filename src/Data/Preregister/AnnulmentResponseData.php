<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class AnnulmentResponseData extends Data
{
    /**
     * @param  array<ValidationErrorData>|null  $errors
     */
    public function __construct(
        public ?string $message,
        #[DataCollectionOf(ValidationErrorData::class)]
        public ?array $errors,
    ) {}
}
