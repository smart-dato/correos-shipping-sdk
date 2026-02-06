<?php

use Illuminate\Support\Facades\Cache;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;
use SmartDato\CorreosShipping\Connectors\PreregisterConnector;
use SmartDato\CorreosShipping\Data\Preregister\AnnulmentRequestData;
use SmartDato\CorreosShipping\Data\Preregister\AnnulmentResponseData;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryRequestData;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryResponseData;
use SmartDato\CorreosShipping\Data\Preregister\GenerateExpeditionResponseData;
use SmartDato\CorreosShipping\Data\Preregister\GenerateShipmentCodeRequestData;
use SmartDato\CorreosShipping\Data\Preregister\QueryRequestData;
use SmartDato\CorreosShipping\Data\Preregister\QueryResponseData;
use SmartDato\CorreosShipping\Requests\Preregister\CancelShipmentRequest;
use SmartDato\CorreosShipping\Requests\Preregister\CreateShipmentsRequest;
use SmartDato\CorreosShipping\Requests\Preregister\GenerateShipmentCodeRequest;
use SmartDato\CorreosShipping\Requests\Preregister\QueryShipmentsRequest;
use SmartDato\CorreosShipping\Requests\Preregister\ValidateShipmentsRequest;
use SmartDato\CorreosShipping\Resources\PreregisterResource;

beforeEach(function () {
    Cache::put('correos_oauth_token', 'fake-test-token', 3600);
});

function preregisterConnector(): PreregisterConnector
{
    config()->set('correos-shipping-sdk.base_urls.preregister', 'https://api1.correos.es/admissions/preregister/api/v1');

    return new PreregisterConnector(
        new CorreosAuthenticator('id', 'secret', 'https://example.com/token', 'AP3', 'gw-id', 'gw-secret')
    );
}

function fixtureJson(string $path): array
{
    return json_decode(file_get_contents(__DIR__.'/../Fixtures/'.$path), true);
}

it('creates shipments and returns delivery response', function () {
    $mockClient = new MockClient([
        CreateShipmentsRequest::class => MockResponse::make(fixtureJson('preregister/delivery_response.json')),
    ]);

    $connector = preregisterConnector();
    $connector->withMockClient($mockClient);
    $resource = new PreregisterResource($connector);

    $requestData = DeliveryRequestData::from(fixtureJson('preregister/delivery_request.json'));
    $response = $resource->createShipments($requestData);

    expect($response)->toBeInstanceOf(DeliveryResponseData::class)
        ->and($response->fileIdentifier)->toBe('FILE001')
        ->and($response->result)->toBe(1)
        ->and($response->shipments)->toHaveCount(1)
        ->and($response->shipments[0]->shipmentCode)->toBe('PQXYZ1234567890')
        ->and($response->shipments[0]->packages[0]->packageCode)->toBe('PQ1DR4A0000012345678');

    $mockClient->assertSent(CreateShipmentsRequest::class);
});

it('validates shipments', function () {
    $mockClient = new MockClient([
        ValidateShipmentsRequest::class => MockResponse::make(fixtureJson('preregister/delivery_response.json')),
    ]);

    $connector = preregisterConnector();
    $connector->withMockClient($mockClient);
    $resource = new PreregisterResource($connector);

    $requestData = DeliveryRequestData::from(fixtureJson('preregister/delivery_request.json'));
    $response = $resource->validateShipments($requestData);

    expect($response)->toBeInstanceOf(DeliveryResponseData::class)
        ->and($response->result)->toBe(1);

    $mockClient->assertSent(ValidateShipmentsRequest::class);
});

it('queries shipments', function () {
    $mockClient = new MockClient([
        QueryShipmentsRequest::class => MockResponse::make(fixtureJson('preregister/query_response.json')),
    ]);

    $connector = preregisterConnector();
    $connector->withMockClient($mockClient);
    $resource = new PreregisterResource($connector);

    $queryData = QueryRequestData::from(['shipments' => ['PQ1DR4A0000012345678']]);
    $response = $resource->queryShipments($queryData);

    expect($response)->toBeInstanceOf(QueryResponseData::class)
        ->and($response->shipments)->toHaveCount(1)
        ->and($response->shipments[0]->shipmentCode)->toBe('PQXYZ1234567890');

    $mockClient->assertSent(QueryShipmentsRequest::class);
});

it('cancels a shipment', function () {
    $mockClient = new MockClient([
        CancelShipmentRequest::class => MockResponse::make(fixtureJson('preregister/annulment_response.json')),
    ]);

    $connector = preregisterConnector();
    $connector->withMockClient($mockClient);
    $resource = new PreregisterResource($connector);

    $annulmentData = AnnulmentRequestData::from(['packageCode' => 'PQ1DR4A0000012345678']);
    $response = $resource->cancelShipment($annulmentData);

    expect($response)->toBeInstanceOf(AnnulmentResponseData::class)
        ->and($response->message)->toBe('Shipment cancelled successfully');

    $mockClient->assertSent(CancelShipmentRequest::class);
});

it('generates a shipment code', function () {
    $mockClient = new MockClient([
        GenerateShipmentCodeRequest::class => MockResponse::make(fixtureJson('preregister/generate_response.json')),
    ]);

    $connector = preregisterConnector();
    $connector->withMockClient($mockClient);
    $resource = new PreregisterResource($connector);

    $generateData = GenerateShipmentCodeRequestData::from([
        'contractNumber' => '12345678',
        'clientNumber' => '1234567890',
        'labellerCode' => '0001',
        'packagesNumber' => '1',
        'product' => 'PAFXB',
        'deliveryMethod' => 'DOUAOF',
    ]);
    $response = $resource->generateShipmentCode($generateData);

    expect($response)->toBeInstanceOf(GenerateExpeditionResponseData::class)
        ->and($response->result)->toBe(1)
        ->and($response->shipmentCode)->toBe('PQXYZ9876543210');

    $mockClient->assertSent(GenerateShipmentCodeRequest::class);
});
