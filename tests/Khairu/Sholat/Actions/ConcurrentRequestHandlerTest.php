<?php

use Khairu\Sholat\Actions\ConcurrentRequestHandler;

it('can add request', function () {
    $handler = new ConcurrentRequestHandler();
    $handler->addRequest('https://example.com/api', function ($response) {
        expect($response)->toContain('Example Domain');
    });

    expect(count($handler->requests))->toBe(1);
});

it('can execute requests', function () {
    $handler = new ConcurrentRequestHandler();
    $handler->addRequest('https://www.e-solat.gov.my/index.php?r=esolatApi/TakwimSolat&period=week&zone=JHR01', function ($response) use($handler){
        $data = json_decode($response, true);
        expect($data)->toHaveKey('status')
            ->and($data['zone'])->toBe('JHR01');
        $handler->responses[] = $data;
    });

    $handler->addRequest('https://www.e-solat.gov.my/index.php?r=esolatApi/TakwimSolat&period=week&zone=SWK02', function ($response) use($handler){
        $data = json_decode($response, true);
        expect($data)->toHaveKey('status')
            ->and($data['zone'])->toBe('SWK02');
        $handler->responses[] = $data;
    });

    $handler->execute();
    expect(count($handler->responses))->toBe(2);
});
