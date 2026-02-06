<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class QueryRequestData extends Data
{
    /**
     * @param  array<string>  $shipments
     */
    public function __construct(
        public array $shipments,
        public string|Optional $orderType,
    ) {}
}
