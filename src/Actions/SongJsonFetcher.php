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

    private string $sholatEndpoint = "https://www.e-solat.gov.my/index.php?r=esolatApi/TakwimSolat&period=week&zone=";

    public array $responses = [];

    protected ExceptionLogger $logger;

    private array $usedKey = [
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

        foreach($this->usedKey as $key => $value) {
            $praying = $service->getPrayingByJsonKey($key);
            $this->prayingId[$key] = $praying->id;
        }

        $service->closeConnection();
    }

    /**
     * Fetches JSON data for subscriber boxes and processes concurrent requests.
     *
     * @return void
     */
    public function fetchBoxJsonData(): void
    {
        $service = new SubscriberBoxService(); // Instantiate SubscriberBoxService
        $service->getConnection(); // Connect to the database

        $data = $service->getAllSubscriberBoxes(); // Get all subscriber boxes data

        $service->closeConnection(); // Close the database connection

        // If there is data available
        if (count($data) > 0) {
            foreach ($data as $rs) {
                // Construct the API URL based on the subscriber's zone
                $api_url = "$this->sholatEndpoint$rs->zone";

                // Add a concurrent request to the handler
                $this->concurrentRequestHandler->addRequest($api_url, function ($response) use ($rs) {
                    // Decode the JSON response
                    $json_data = json_decode($response, true);

                    // Store the JSON data in responses array
                    $this->responses[$rs->subscriber_id][$rs->box_id] = $json_data;
                });
            }

            try {
                // Execute concurrent requests
                $this->concurrentRequestHandler->execute();
            } catch (Exception $e) {
                // Handle exception and report to logger
                $this->logger->report(false, $e->getMessage());
                echo "[!] Unable to get the JSON {$e->getMessage()}" . PHP_EOL;
                exit(); // Exit the script
            }
        }
    }


    /**
     * Processes the API response to extract prayer time data and add songs to the database.
     *
     * @return void
     */
    public function processResponse(): void
    {
        $all_data = []; // Initialize an array to store all song data

        // Check if there are responses in the API
        if (sizeof($this->responses) === 0) {
            echo "[!] Unable to read JSON from API response" . PHP_EOL;
            $this->logger->report(false, "Unable to read JSON from API response");
            exit(); // Exit the script as JSON data couldn't be read
        }

        // Iterate through each response box
        foreach ($this->responses as $box) {
            foreach ($box as $id => $songs) {
                if ($songs['status'] === 'OK!') {
                    $prayerTime = $songs['prayerTime'];
                    foreach ($prayerTime as $timeData) {
                        foreach ($this->usedKey as $key => $label) {
                            if (array_key_exists($key, $timeData)) {
                                $datetime = $this->createDateTimeObject($timeData['date'], $timeData[$key]);
                                $data = new Song(null, $this->prayingId[$key], $id, $datetime);
                                $all_data[] = $data;
                            }
                        }
                    }
                } else {
                    $this->logger->report(false, "Request is failed", $id, $songs['zone']);
                }
            }
        }       

        // If there is data to be added, connect to the SongService and add the songs
        if ($all_data) {
            $service = new SongService();
            $service->getConnection(); // Connect to the database
            $service->addBulkSongs($all_data); // Add songs in bulk
            $service->closeConnection(); // Close the database connection
        }
    }

    private function createDateTimeObject(string $date, string $time): \DateTime
    {
        $dateTimeString = $date . ' ' . $time;
        return new \DateTime($dateTimeString);
    }
}
