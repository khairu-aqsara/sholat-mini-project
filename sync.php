<?php
require 'vendor/autoload.php';

$boxJsonFetcher = new \Khairu\Sholat\Actions\SongJsonFetcher();
$boxJsonFetcher->getIdForPrayingName();
$boxJsonFetcher->fetchBoxJsonData();
$boxJsonFetcher->process_response();