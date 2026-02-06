<?php

namespace SmartDato\CorreosShipping\Data\Preregister;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AddresseeData extends Data
{
    public function __construct(
        public string|Optional $name,
        public string|Optional $lastName1,
        public string|Optional $lastName2,
        public string|Optional $company,
        public string|Optional $contactPerson,
        public string|Optional $doiType,
        public string|Optional $doiNumber,
        public string|Optional $addressType,
        public string $address,
        public string|Optional $number,
        public string|Optional $portal,
        public string|Optional $block,
        public string|Optional $staircase,
        public string|Optional $floor,
        public string|Optional $door,
        public string|Optional $addressComplement,
        public string $locality,
        public string $province,
        public string $cp,
        public string|Optional $zip,
        public string $country,
        public string|Optional $contactPhone,
        public string|Optional $email,
        public string|Optional $smsNumber,
        public string|Optional $language,
        public string|Optional $chosenOffice,
        public string|Optional $homepaqCode,
        public string|Optional $internationalDestinyPoBox,
    ) {}
}
