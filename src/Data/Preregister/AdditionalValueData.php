<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class AdditionalValueData extends Data
{
    /**
     * @param  array<AdditionalValueFieldData>  $fields
     */
    public function __construct(
        public string $additionalValueId,
        #[DataCollectionOf(AdditionalValueFieldData::class)]
        public array $fields,
    ) {}
}
