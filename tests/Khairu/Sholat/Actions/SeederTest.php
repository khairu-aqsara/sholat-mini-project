<?php

use Khairu\Sholat\Actions\Seeder;
use Khairu\Sholat\Models\Database;
use Khairu\Sholat\Services\BoxService;
use Khairu\Sholat\Services\PrayingNameService;
use Khairu\Sholat\Services\SubscriberBoxService;
use Khairu\Sholat\Services\SubscriberService;
use Khairu\Sholat\Services\ZoneService;

it('can truncate tables', function () {
    // Create a mock for the Database class
    $databaseMock = Mockery::mock(Database::class);
    $databaseMock->shouldReceive('executeQuery')->times(8);

    $seeder = new Seeder($databaseMock);
    $seeder->truncateTables();
});

it('can seed subscribers', function () {
    // Create a mock for the SubscriberService class
    $subscriberServiceMock = Mockery::mock('overload:' . SubscriberService::class);
    $subscriberServiceMock->shouldReceive('getConnection')->once();
    $subscriberServiceMock->shouldReceive('addSubscriber')->twice();
    $subscriberServiceMock->shouldReceive('closeConnection')->once();

    $seeder = new Seeder(Mockery::mock(Database::class));
    $seeder->seedSubscribers();
});

it('can seed praying names', function () {
    // Create a mock for the PrayingNameService class
    $prayingNameServiceMock = Mockery::mock('overload:' . PrayingNameService::class);
    $prayingNameServiceMock->shouldReceive('getConnection')->once();
    $prayingNameServiceMock->shouldReceive('addPrayingName')->times(6);
    $prayingNameServiceMock->shouldReceive('closeConnection')->once();

    $seeder = new Seeder(Mockery::mock(Database::class));
    $seeder->seedPrayingName();
});

it('can seed zones', function () {
    // Create a mock for the ZoneService class
    $zoneServiceMock = Mockery::mock('overload:' . ZoneService::class);
    $zoneServiceMock->shouldReceive('getConnection')->once();
    $zoneServiceMock->shouldReceive('addZone')->times(18);
    $zoneServiceMock->shouldReceive('closeConnection')->once();

    $seeder = new Seeder(Mockery::mock(Database::class));
    $seeder->seedZones();
});

it('can seed boxes', function () {
    // Create a mock for the BoxService class
    $boxServiceMock = Mockery::mock('overload:' . BoxService::class);
    $boxServiceMock->shouldReceive('getConnection')->once();
    $boxServiceMock->shouldReceive('addBox')->times(5);
    $boxServiceMock->shouldReceive('closeConnection')->once();

    $seeder = new Seeder(Mockery::mock(Database::class));
    $seeder->seedBoxes();
});

it('can seed subscriber boxes', function () {
    // Create a mock for the SubscriberBoxService class
    $subscriberBoxServiceMock = Mockery::mock('overload:' . SubscriberBoxService::class);
    $subscriberBoxServiceMock->shouldReceive('getConnection')->once();
    $subscriberBoxServiceMock->shouldReceive('addSubscriberBox')->times(5);
    $subscriberBoxServiceMock->shouldReceive('closeConnection')->once();

    $seeder = new Seeder(Mockery::mock(Database::class));
    $seeder->seedSubscriberBoxes();
});

