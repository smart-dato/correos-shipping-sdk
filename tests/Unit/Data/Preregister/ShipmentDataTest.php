<?php

use SmartDato\CorreosShipping\Data\Preregister\AddresseeData;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryRequestData;
use SmartDato\CorreosShipping\Data\Preregister\DeliveryResponseData;
use SmartDato\CorreosShipping\Data\Preregister\PackageData;
use SmartDato\CorreosShipping\Data\Preregister\SenderData;
use SmartDato\CorreosShipping\Data\Preregister\ShipmentData;

it('creates delivery request data from array', function () {
    $json = file_get_contents(__DIR__.'/../../../Fixtures/preregister/delivery_request.json');
    $data = DeliveryRequestData::from(json_decode($json, true));

    expect($data->shipments)->toHaveCount(1)
        ->and($data->shipments[0])->toBeInstanceOf(ShipmentData::class)
        ->and($data->shipments[0]->product)->toBe('PAFXB')
        ->and($data->shipments[0]->deliveryMethod)->toBe('DOUAOF')
        ->and($data->shipments[0]->contractNumber)->toBe('12345678')
        ->and($data->shipments[0]->sender)->toBeInstanceOf(SenderData::class)
        ->and($data->shipments[0]->sender->name)->toBe('Test Sender')
        ->and($data->shipments[0]->addressee)->toBeInstanceOf(AddresseeData::class)
        ->and($data->shipments[0]->addressee->name)->toBe('Test Addressee')
        ->and($data->shipments[0]->packages)->toHaveCount(1)
        ->and($data->shipments[0]->packages[0])->toBeInstanceOf(PackageData::class)
        ->and($data->shipments[0]->packages[0]->packageWeightGrams)->toBe('500');
});

it('serializes delivery request data to array', function () {
    $json = file_get_contents(__DIR__.'/../../../Fixtures/preregister/delivery_request.json');
    $data = DeliveryRequestData::from(json_decode($json, true));
    $array = $data->toArray();

    expect($array)->toHaveKey('shipments')
        ->and($array['shipments'])->toHaveCount(1)
        ->and($array['shipments'][0])->toHaveKey('product', 'PAFXB')
        ->and($array['shipments'][0])->toHaveKey('deliveryMethod', 'DOUAOF')
        ->and($array['shipments'][0]['sender'])->toHaveKey('name', 'Test Sender')
        ->and($array['shipments'][0]['packages'][0])->toHaveKey('packageWeightGrams', '500');
});

it('deserializes delivery response data', function () {
    $json = file_get_contents(__DIR__.'/../../../Fixtures/preregister/delivery_response.json');
    $data = DeliveryResponseData::from(json_decode($json, true));

    expect($data->fileIdentifier)->toBe('FILE001')
        ->and($data->result)->toBe(1)
        ->and($data->shipments)->toHaveCount(1)
        ->and($data->shipments[0]->validationErrorCount)->toBe(0)
        ->and($data->shipments[0]->shipmentCode)->toBe('PQXYZ1234567890')
        ->and($data->shipments[0]->packages[0]->packageCode)->toBe('PQ1DR4A0000012345678');
});

it('omits optional fields from serialized output', function () {
    $sender = SenderData::from([
        'name' => 'John',
        'address' => 'Street 1',
        'locality' => 'Madrid',
        'province' => '28',
        'cp' => '28001',
        'country' => 'ESP',
    ]);

    $array = $sender->toArray();

    expect($array)->toHaveKey('name', 'John')
        ->toHaveKey('address', 'Street 1')
        ->not->toHaveKey('lastName1')
        ->not->toHaveKey('company')
        ->not->toHaveKey('contactPhone');
});
