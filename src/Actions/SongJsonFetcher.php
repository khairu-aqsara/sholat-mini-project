<?php

namespace Khairu\Sholat\Actions;

use Exception;
use Khairu\Sholat\Exceptions\ExceptionLogger;
use Khairu\Sholat\Models\Song;
use Khairu\Sholat\Services\PrayingNameService;
use Khairu\Sholat\Services\SongService;
use Khairu\Sholat\Services\SubscriberBoxService;
use PDOException;

/**
 * Class SongJsonFetcher
 * Fetches JSON data for each record in the Box table using ConcurrentRequestHandler.
 */
class SongJsonFetcher
{
    private ConcurrentRequestHandler $concurrentRequestHandler;

    private string $sholat_endpoint = "https://www.e-solat.gov.my/index.php?r=esolatApi/TakwimSolat&period=week&zone=";

    public array $responses = [];

    protected ExceptionLogger $logger;

    private array $used_key = [
        'imsak' => 'Imsak',
        'fajr' => 'Subuh',
        'dhuhr' => 'Zohor',
        'asr' => 'Asar',
        'maghrib' => 'Maghrib',
        'isha' => 'Isyak'
    ];

    public array $prayingId = [];

    /**
     * Constructor for SongJsonFetcher class.
     * Initializes Database and ConcurrentRequestHandler objects.
     */
    public function __construct()
    {
        $this->concurrentRequestHandler = new ConcurrentRequestHandler();
        $this->logger = new ExceptionLogger();
    }

    public function getIdForPrayingName(): void
    {
        $service = new PrayingNameService();
        $service->getConnection();

        foreach($this->used_key as $key => $value) {
            $praying = $service->getPrayingByJsonKey($key);
            $this->prayingId[$key] = $praying->id;
        }

        $service->closeConnection();
    }

    /**
     * Fetches JSON data for each record in the Box table using ConcurrentRequestHandler.
     * Retrieves prayer time data from external API for each subscriber's box.
     *
     * @throws PDOException If an error occurs while fetching data from the database.
     */
    public function fetchBoxJsonData(): void
    {
        $service = new SubscriberBoxService();
        $service->getConnection();

        $data = $service->getAllSubscriberBoxes();

        $service->closeConnection();

        if(count($data) > 0) {
            foreach($data as $rs) {
                $api_url = "$this->sholat_endpoint$rs->zone";
                $this->concurrentRequestHandler->addRequest($api_url, function($response) use($rs) {
                    $json_data = json_decode($response, true);
                    $this->responses[$rs->subscriber_id][$rs->box_id] = $json_data;
                });
            }

            try {
                $this->concurrentRequestHandler->execute();
            }catch (Exception $e){
                $this->logger->report(false, $e->getMessage());
                echo "[!] Unable to get the JSON {$e->getMessage()}". PHP_EOL;
                exit();
            }
        }
    }

    /**
     * Processes the JSON responses received from API.
     * Extracts relevant data and prepares it for bulk insertion into the database.
     */
    public function process_response(): void
    {
        $all_data = [];

        if(sizeof($this->responses) === 0) {
            echo "[!] Unable to read JSON from api response". PHP_EOL;
            exit();
        }

        foreach ($this->responses as $box) {
            foreach ($box as $id => $songs) {
                if ($songs['status'] === 'OK!') {
                    $prayer_time = $songs['prayerTime'];
                    foreach ($prayer_time as $value) {
                        foreach ($this->used_key as $key => $label) {
                            if (isset($value[$key])) {
                                $datetime = date("Y-m-d H:i:s", strtotime($value['date']." ".$value[$key]));
                                $data = new Song(
                                    null,
                                    $this->prayingId[$key],
                                    $id,
                                    $datetime
                                );
                                $all_data[] = $data;
                            }
                        }
                    }
                }
            }
        }
        if ($all_data) {
            $service = new SongService();
            $service->getConnection();
            $service->addBulkSongs($all_data);
            $service->closeConnection();
        }
    }
}
