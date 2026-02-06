<?php

namespace SmartDato\CorreosShipping\Data\Labels;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PrintData extends Data
{
    /**
     * @param  array<string>  $shipments
     */
    public function __construct(
        public array $shipments,
        public int $labelFormat,
        public int $labelPrintMode,
        public int|Optional $labelOrderType,
        public int|Optional $labelPrintInitialPosition,
        public string|Optional $clientLogo,
    ) {}
}
