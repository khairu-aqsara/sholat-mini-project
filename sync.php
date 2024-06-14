<?php

use Khairu\Sholat\Actions\SongJsonFetcher;

require_once 'vendor/autoload.php';

$boxJsonFetcher = new SongJsonFetcher();
$boxJsonFetcher->getIdForPrayingName();
$boxJsonFetcher->fetchBoxJsonData();
$boxJsonFetcher->processResponse();