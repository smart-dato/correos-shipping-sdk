<?php

use Illuminate\Support\Facades\Cache;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SmartDato\CorreosShipping\Auth\CorreosAuthenticator;
use SmartDato\CorreosShipping\Connectors\LabelsConnector;
use SmartDato\CorreosShipping\Data\Labels\DocumentResponseData;
use SmartDato\CorreosShipping\Data\Labels\LabelsResponseData;
use SmartDato\CorreosShipping\Data\Labels\PrintDocumentsRequestData;
use SmartDato\CorreosShipping\Data\Labels\PrintLabelsRequestData;
use SmartDato\CorreosShipping\Requests\Labels\PrintDocumentsRequest;
use SmartDato\CorreosShipping\Requests\Labels\PrintLabelsRequest;
use SmartDato\CorreosShipping\Resources\LabelsResource;

beforeEach(function () {
    Cache::put('correos_oauth_token', 'fake-test-token', 3600);
});

function labelsConnector(): LabelsConnector
{
    config()->set('correos-shipping-sdk.base_urls.labels', 'https://api1.correos.es/support/labels/api/v1');

    return new LabelsConnector(
        new CorreosAuthenticator('id', 'secret', 'https://example.com/token', 'AP3', 'gw-id', 'gw-secret')
    );
}

it('prints labels and returns pdf', function () {
    $mockClient = new MockClient([
        PrintLabelsRequest::class => MockResponse::make(
            json_decode(file_get_contents(__DIR__.'/../Fixtures/labels/labels_response.json'), true)
        ),
    ]);

    $connector = labelsConnector();
    $connector->withMockClient($mockClient);
    $resource = new LabelsResource($connector);

    $requestData = PrintLabelsRequestData::from([
        'documentationType' => 1,
        'print' => [
            'shipments' => ['PQXYZ1234567890'],
            'labelFormat' => 2,
            'labelPrintMode' => 1,
        ],
    ]);

    $response = $resource->printLabels($requestData);

    expect($response)->toBeInstanceOf(LabelsResponseData::class)
        ->and($response->pdf)->not->toBeNull()
        ->and($response->error)->toBeNull();

    $mockClient->assertSent(PrintLabelsRequest::class);
});

it('prints documents and returns pdf', function () {
    $mockClient = new MockClient([
        PrintDocumentsRequest::class => MockResponse::make(
            json_decode(file_get_contents(__DIR__.'/../Fixtures/labels/document_response.json'), true)
        ),
    ]);

    $connector = labelsConnector();
    $connector->withMockClient($mockClient);
    $resource = new LabelsResource($connector);

    $requestData = PrintDocumentsRequestData::from([
        'documentationType' => 5,
        'documentData' => [
            'destinationName' => 'France',
        ],
    ]);

    $response = $resource->printDocuments($requestData);

    expect($response)->toBeInstanceOf(DocumentResponseData::class)
        ->and($response->pdf)->not->toBeNull()
        ->and($response->error)->toBeNull();

    $mockClient->assertSent(PrintDocumentsRequest::class);
});
