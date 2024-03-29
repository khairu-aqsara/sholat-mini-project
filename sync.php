<?php

use Khairu\Sholat\Actions\SongJsonFetcher;

require 'vendor/autoload.php';

$boxJsonFetcher = new SongJsonFetcher();
$boxJsonFetcher->getIdForPrayingName();
$boxJsonFetcher->fetchBoxJsonData();
$boxJsonFetcher->process_response();