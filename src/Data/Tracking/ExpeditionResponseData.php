<?php

namespace SmartDato\CorreosShipping\Data\Tracking;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class ExpeditionResponseData extends Data
{
    /**
     * @param  array<ExpeditionClientData>|null  $clients
     * @param  array<ExpeditionPackageData>|null  $packages
     * @param  array<TrackingErrorData>|null  $error
     */
    public function __construct(
        public ?string $refExpedition,
        public ?string $numReferencia,
        public ?string $serviceCode,
        public ?string $serviceDescription,
        public ?string $entryDate,
        public ?string $deliveryDate,
        public ?string $deliveryUnit,
        public ?string $deliveryProvince,
        #[DataCollectionOf(ExpeditionClientData::class)]
        public ?array $clients,
        #[DataCollectionOf(ExpeditionPackageData::class)]
        public ?array $packages,
        #[DataCollectionOf(TrackingErrorData::class)]
        public ?array $error,
    ) {}
}
