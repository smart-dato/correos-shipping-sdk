<?php

use Illuminate\Support\Facades\Cache;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;
use SmartDato\CorreosShipping\Connectors\TrackingConnector;
use SmartDato\CorreosShipping\Data\Tracking\ExpeditionResponseData;
use SmartDato\CorreosShipping\Data\Tracking\ShipmentSearchResponseData;
use SmartDato\CorreosShipping\Requests\Tracking\GetExpeditionRequest;
use SmartDato\CorreosShipping\Requests\Tracking\SearchShipmentRequest;
use SmartDato\CorreosShipping\Resources\TrackingResource;

beforeEach(function () {
    Cache::put('correos_oauth_token', 'fake-test-token', 3600);
});

function trackingConnector(): TrackingConnector
{
    config()->set('correos-shipping-sdk.base_urls.tracking', 'https://api1.correos.es/support/trackpub/api/v2');

    return new TrackingConnector(
        new CorreosAuthenticator('id', 'secret', 'https://example.com/token', 'AP3', 'gw-id', 'gw-secret')
    );
}

it('searches for a shipment', function () {
    $mockClient = new MockClient([
        SearchShipmentRequest::class => MockResponse::make(
            json_decode(file_get_contents(__DIR__.'/../Fixtures/tracking/search_response.json'), true)
        ),
    ]);

    $connector = trackingConnector();
    $connector->withMockClient($mockClient);
    $resource = new TrackingResource($connector);

    $response = $resource->searchShipment('PQ1DR4A0000012345678');

    expect($response)->toBeInstanceOf(ShipmentSearchResponseData::class)
        ->and($response->code)->toBe('PQ1DR4A0000012345678')
        ->and($response->codProduct)->toBe('PQDOM')
        ->and($response->remitName)->toBe('Test Sender')
        ->and($response->destiName)->toBe('Test Addressee')
        ->and($response->events)->toHaveCount(1)
        ->and($response->events[0]->eventCode)->toBe('P010000V')
        ->and($response->events[0]->summaryText)->toBe('Shipment preregistered');

    $mockClient->assertSent(SearchShipmentRequest::class);
});

it('gets expedition details', function () {
    $mockClient = new MockClient([
        GetExpeditionRequest::class => MockResponse::make(
            json_decode(file_get_contents(__DIR__.'/../Fixtures/tracking/expedition_response.json'), true)
        ),
    ]);

    $connector = trackingConnector();
    $connector->withMockClient($mockClient);
    $resource = new TrackingResource($connector);

    $response = $resource->getExpedition('EXP001234567890');

    expect($response)->toBeInstanceOf(ExpeditionResponseData::class)
        ->and($response->refExpedition)->toBe('EXP001234567890')
        ->and($response->serviceDescription)->toBe('Paq Premium')
        ->and($response->clients)->toHaveCount(1)
        ->and($response->clients[0]->businessName)->toBe('Test Company')
        ->and($response->packages)->toHaveCount(1)
        ->and($response->packages[0]->shippingCode)->toBe('PQ1DR4A0000012345678');

    $mockClient->assertSent(GetExpeditionRequest::class);
});
