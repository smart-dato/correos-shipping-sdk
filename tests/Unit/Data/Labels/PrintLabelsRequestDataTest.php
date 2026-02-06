<?php

use SmartDato\CorreosShipping\Data\Labels\LabelsResponseData;
use SmartDato\CorreosShipping\Data\Labels\PrintData;
use SmartDato\CorreosShipping\Data\Labels\PrintLabelsRequestData;

it('creates print labels request data', function () {
    $data = PrintLabelsRequestData::from([
        'documentationType' => 1,
        'print' => [
            'shipments' => ['PQXYZ1234567890'],
            'labelFormat' => 2,
            'labelPrintMode' => 1,
        ],
    ]);

    expect($data->documentationType)->toBe(1)
        ->and($data->print)->toBeInstanceOf(PrintData::class)
        ->and($data->print->shipments)->toBe(['PQXYZ1234567890'])
        ->and($data->print->labelFormat)->toBe(2)
        ->and($data->print->labelPrintMode)->toBe(1);
});

it('serializes print labels request data without optional fields', function () {
    $data = PrintLabelsRequestData::from([
        'documentationType' => 0,
        'print' => [
            'shipments' => ['CODE1', 'CODE2'],
            'labelFormat' => 2,
            'labelPrintMode' => 1,
        ],
    ]);

    $array = $data->toArray();

    expect($array)->toHaveKey('documentationType', 0)
        ->toHaveKey('print')
        ->not->toHaveKey('application');

    expect($array['print'])->toHaveKey('shipments', ['CODE1', 'CODE2'])
        ->toHaveKey('labelFormat', 2)
        ->not->toHaveKey('clientLogo');
});

it('deserializes labels response data', function () {
    $json = file_get_contents(__DIR__.'/../../../Fixtures/labels/labels_response.json');
    $data = LabelsResponseData::from(json_decode($json, true));

    expect($data->pdf)->toBe('JVBERi0xLjQgZmFrZSBwZGYgY29udGVudA==')
        ->and($data->zpl)->toBeNull()
        ->and($data->xml)->toBeNull()
        ->and($data->error)->toBeNull();
});
