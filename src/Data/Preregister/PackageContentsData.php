<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PackageContentsData extends Data
{
    /**
     * @param  array<CustomItemData>|Optional  $customsData
     */
    public function __construct(
        public string $shipmentType,
        public string|Optional $invoiceNumber,
        public string|Optional $licenseNumber,
        public string|Optional $certificateNumber,
        public string|Optional $customReferenceConsignor,
        public string|Optional $importerTaxReference,
        public string|Optional $importerVatNumber,
        public string|Optional $importerCode,
        public string|Optional $phoneNumber,
        public string|Optional $importerEmail,
        public string|Optional $instructionsDoNotDeliver,
        public string|Optional $indDangerousGoods,
        public string|Optional $indCommercialDelivery,
        public string|Optional $indInvoiceExceedsAmount,
        public string|Optional $indDUAwithCorreos,
        #[DataCollectionOf(CustomItemData::class)]
        public array|Optional $customsData,
    ) {}
}
