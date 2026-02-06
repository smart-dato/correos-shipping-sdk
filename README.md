# Correos Shipping SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smart-dato/correos-shipping-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/correos-shipping-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/correos-shipping-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smart-dato/correos-shipping-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/correos-shipping-sdk/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/smart-dato/correos-shipping-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smart-dato/correos-shipping-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/correos-shipping-sdk)

Laravel package for integrating with the Correos (Spanish postal service) APIs. Supports shipment preregistration, label and customs document generation, and tracking. Built on [Saloon 3.x](https://docs.saloon.dev) for HTTP and [Spatie Laravel Data 4.x](https://spatie.be/docs/laravel-data) for DTOs.

## Requirements

- PHP 8.4+
- Laravel 11 or 12

## Installation

Install the package via Composer:

```bash
composer require smart-dato/correos-shipping-sdk
```

Publish the config file:

```bash
php artisan vendor:publish --tag="correos-shipping-sdk-config"
```

## Configuration

Add the following environment variables to your `.env` file:

```env
# OAuth credentials (CorreosID)
CORREOS_OAUTH_CLIENT_ID=your-oauth-client-id
CORREOS_OAUTH_CLIENT_SECRET=your-oauth-client-secret

# API Gateway credentials
CORREOS_GATEWAY_CLIENT_ID=your-gateway-client-id
CORREOS_GATEWAY_CLIENT_SECRET=your-gateway-client-secret
```

The published config file (`config/correos-shipping-sdk.php`) contains all available options:

```php
return [
    'oauth' => [
        'client_id'     => env('CORREOS_OAUTH_CLIENT_ID'),
        'client_secret' => env('CORREOS_OAUTH_CLIENT_SECRET'),
        'token_url'     => env('CORREOS_TOKEN_URL', 'https://apioauthcid.correos.es/Api/Authorize/Token'),
        'scope'         => env('CORREOS_OAUTH_SCOPE', 'AP3 LBS RCG'),
    ],
    'gateway' => [
        'client_id'     => env('CORREOS_GATEWAY_CLIENT_ID'),
        'client_secret' => env('CORREOS_GATEWAY_CLIENT_SECRET'),
    ],
    'base_urls' => [
        'preregister' => env('CORREOS_PREREGISTER_URL', 'https://api1.correos.es/admissions/preregister/api/v1'),
        'labels'      => env('CORREOS_LABELS_URL', 'https://api1.correos.es/support/labels/api/v1'),
        'tracking'    => env('CORREOS_TRACKING_URL', 'https://api1.correos.es/support/trackpub/api/v2'),
    ],
];
```

For the **pre-production** environment, override the URLs:

```env
CORREOS_TOKEN_URL=https://apioauthcid.correospre.es/Api/Authorize/Token
CORREOS_PREREGISTER_URL=https://api1.correospre.es/admissions/preregister/api/v1
CORREOS_LABELS_URL=https://api1.correospre.es/support/labels/api/v1
CORREOS_TRACKING_URL=https://api1.correospre.es/support/trackpub/api/v2
```

## Usage

Resolve the SDK from the container (or use the `CorreosShipping` facade):

```php
use SmartDato\CorreosShipping\CorreosShipping;

$correos = app(CorreosShipping::class);
```

### Preregister Shipments

```php
use SmartDato\CorreosShipping\Data\Preregister\DeliveryRequestData;

$request = DeliveryRequestData::from([
    'shipments' => [
        [
            'product' => 'PAFXB',
            'deliveryMethod' => 'DOUAOF',
            'contractNumber' => '12345678',
            'clientNumber' => '1234567890',
            'labellerCode' => '0001',
            'packagesNumber' => '1',
            'sender' => [
                'name' => 'My Company',
                'address' => 'Calle Sender 1',
                'locality' => 'Madrid',
                'province' => '28',
                'cp' => '28001',
                'country' => 'ESP',
            ],
            'addressee' => [
                'name' => 'John Doe',
                'address' => 'Calle Receiver 2',
                'locality' => 'Barcelona',
                'province' => '08',
                'cp' => '08001',
                'country' => 'ESP',
            ],
            'packages' => [
                ['packageWeightGrams' => '500'],
            ],
        ],
    ],
]);

// Validate before creating
$validation = $correos->preregister()->validateShipments($request);

// Create the shipment
$response = $correos->preregister()->createShipments($request);

$response->fileIdentifier;  // "FILE001"
$response->shipments[0]->shipmentCode;  // "PQXYZ1234567890"
$response->shipments[0]->packages[0]->packageCode;  // "PQ1DR4A0000012345678"
```

### Print Labels

```php
use SmartDato\CorreosShipping\Data\Labels\PrintLabelsRequestData;

$labelRequest = PrintLabelsRequestData::from([
    'documentationType' => 1, // 0=All, 1=Label, 2=CN22/CN23
    'print' => [
        'shipments' => ['PQXYZ1234567890'],
        'labelFormat' => 2,    // 1=XML, 2=PDF, 3=ZPL
        'labelPrintMode' => 1, // 1=A4, 2=Labeler
    ],
]);

$labels = $correos->labels()->printLabels($labelRequest);

$labels->pdf;  // Base64-encoded PDF content
```

### Print Customs Documents (DCAF/DDP)

```php
use SmartDato\CorreosShipping\Data\Labels\PrintDocumentsRequestData;

$docRequest = PrintDocumentsRequestData::from([
    'documentationType' => 5, // 5=DCAF, 6=DDP
    'documentData' => [
        'destinationName' => 'France',
        'contractNumber' => '12345678',
        'clientNumber' => '1234567890',
    ],
]);

$document = $correos->labels()->printDocuments($docRequest);

$document->pdf;  // Base64-encoded PDF
```

### Track Shipments

```php
$tracking = $correos->tracking()->searchShipment('PQ1DR4A0000012345678');

$tracking->code;          // "PQ1DR4A0000012345678"
$tracking->codProduct;    // "PQDOM"
$tracking->remitName;     // Sender name
$tracking->destiName;     // Addressee name
$tracking->events;        // Array of TrackingEventData

foreach ($tracking->events as $event) {
    $event->eventDate;     // "06/02/2026"
    $event->eventCode;     // "P010000V"
    $event->summaryText;   // "Shipment preregistered"
    $event->location;      // "CTA MADRID"
}
```

### Track Expeditions

```php
$expedition = $correos->tracking()->getExpedition('EXP001234567890');

$expedition->refExpedition;       // "EXP001234567890"
$expedition->serviceDescription;  // "Paq Premium"
$expedition->clients;             // Array of ExpeditionClientData
$expedition->packages;            // Array of ExpeditionPackageData
```

### Other Preregister Operations

```php
// Cancel a shipment
$correos->preregister()->cancelShipment(
    AnnulmentRequestData::from(['packageCode' => 'PQ1DR4A0000012345678'])
);

// Cancel an expedition
$correos->preregister()->cancelExpedition(
    AnnulmentExpeditionRequestData::from(['expeditionCode' => 'EXP001234567890'])
);

// Generate shipment codes
$correos->preregister()->generateShipmentCode(
    GenerateShipmentCodeRequestData::from([
        'contractNumber' => '12345678',
        'clientNumber' => '1234567890',
        'labellerCode' => '0001',
        'packagesNumber' => '1',
        'product' => 'PAFXB',
        'deliveryMethod' => 'DOUAOF',
    ])
);

// Modify a shipment
$correos->preregister()->modifyShipment($deliveryRequestData);

// Query shipments
$correos->preregister()->queryShipments(
    QueryRequestData::from(['shipments' => ['PQ1DR4A0000012345678']])
);

// Get expedition packages
$correos->preregister()->getExpeditionPackages('EXP001234567890');

// Search by client reference
$correos->preregister()->getPackagesByReference('MY-REF-001');

// Backoffice queries
$correos->preregister()->getBackofficeShipment('PQXYZ1234567890');
$correos->preregister()->getBackofficeErrors(contractNumber: '12345678');
$correos->preregister()->getBackofficeTotal(dateFrom: '01/01/2026', dateTo: '31/01/2026');
$correos->preregister()->getBackofficeWaiting();
```

### Using the Facade

```php
use SmartDato\CorreosShipping\Facades\CorreosShipping;

$response = CorreosShipping::preregister()->createShipments($request);
$labels = CorreosShipping::labels()->printLabels($labelRequest);
$tracking = CorreosShipping::tracking()->searchShipment('PQ1DR4A0000012345678');
```

## Available Enums

The package provides typed enums for API constants:

```php
use SmartDato\CorreosShipping\Enums\DocumentationType;  // All, Label, CN22_CN23, DCAF, DDP
use SmartDato\CorreosShipping\Enums\LabelFormat;         // XML, PDF, ZPL
use SmartDato\CorreosShipping\Enums\LabelPrintMode;      // A4, Labeler
use SmartDato\CorreosShipping\Enums\LabelOrderType;      // InternationalPoBox, Company, LastName, PackageId, ClientReference
use SmartDato\CorreosShipping\Enums\ShipmentType;        // Documents, Goods, Gift, Samples, Returns, Other, Dangerous
use SmartDato\CorreosShipping\Enums\DoiType;             // European, DNI, NIE, Other, CIF
use SmartDato\CorreosShipping\Enums\AdmissionMethod;     // Office, Citypaq, DeliveryUnit
use SmartDato\CorreosShipping\Enums\ErrorCodeLanguage;   // Spanish, English
```

## Error Handling

API errors are thrown as `CorreosApiException`:

```php
use SmartDato\CorreosShipping\Exceptions\CorreosApiException;

try {
    $response = $correos->preregister()->createShipments($request);
} catch (CorreosApiException $e) {
    $e->getMessage();         // Error message from the API
    $e->getCode();            // HTTP status code
    $e->errorCode;            // Correos error code
    $e->moreInformation;     // Additional error details
}
```

## Testing

```bash
composer test             # Run tests
composer analyse          # Static analysis (PHPStan level 5)
composer format           # Code style (Laravel Pint)
composer test-coverage    # Tests with coverage report
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SmartDato](https://github.com/smart-dato)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
