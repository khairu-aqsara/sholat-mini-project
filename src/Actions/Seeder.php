<?php

namespace Khairu\Sholat\Actions;

use Khairu\Sholat\Models\Box;
use Khairu\Sholat\Models\Database;
use Khairu\Sholat\Models\PrayingName;
use Khairu\Sholat\Models\Subscriber;
use Khairu\Sholat\Models\SubscriberBox;
use Khairu\Sholat\Models\Zone;
use Khairu\Sholat\Services\BoxService;
use Khairu\Sholat\Services\PrayingNameService;
use Khairu\Sholat\Services\SubscriberBoxService;
use Khairu\Sholat\Services\SubscriberService;
use Khairu\Sholat\Services\ZoneService;
use PDOException;

/**
 * Class Seeder
 * Handles database seeding operations for subscribers, boxes, and songs.
 */
class Seeder
{
    /** @var Database Database connection */
    private Database $database;

    /**
     * Seeder constructor.
     * @param Database $database Database connection
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Truncate tables (subscribers, boxes, songs) to clear existing data.
     */
    public function truncateTables(): void
    {
        try {
            // Disable foreign key checks
            $this->database->executeQuery("SET FOREIGN_KEY_CHECKS = 0");

            // Truncate the subscriber, box, and song tables
            $this->database->executeQuery("TRUNCATE TABLE subscribers");
            $this->database->executeQuery("TRUNCATE TABLE zones");
            $this->database->executeQuery("TRUNCATE TABLE boxes");
            $this->database->executeQuery("TRUNCATE TABLE subscriber_boxes");
            $this->database->executeQuery("TRUNCATE TABLE praying_name");
            $this->database->executeQuery("TRUNCATE TABLE songs");

            // Enable foreign key checks
            $this->database->executeQuery("SET FOREIGN_KEY_CHECKS = 1");

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Seed subscribers into the database and seed corresponding boxes based on the subscribers.
     */
    public function seedSubscribers(): static
    {
        $subscriber_services = new SubscriberService();

        $subscriber = [
            new Subscriber(null, 'The Café'),
            new Subscriber(null, 'My Restaurant')
        ];

        $subscriber_services->getConnection();

        foreach($subscriber as $sub) {
            $subscriber_services->addSubscriber($sub);
        }

        $subscriber_services->closeConnection();

        echo "[+] Seed initial subscribers into the database completed" . PHP_EOL;

        return $this;
    }

    public function seedPrayingName(): static
    {
        $praying_service = new PrayingNameService();
        $praying_service->getConnection();

        $data = [
            new PrayingName(null, 'Imsak', 'imsak', 1),
            new PrayingName(null, 'Subuh', 'fajr', 2),
            new PrayingName(null, 'Zohor', 'dhuhr', 3),
            new PrayingName(null, 'Asar', 'asr', 4),
            new PrayingName(null, 'Maghrib', 'maghrib',5),
            new PrayingName(null, 'Isyak', 'isha',6)
        ];

        foreach($data as $rs) {
            $praying_service->addPrayingName($rs);
        }

        $praying_service->closeConnection();

        echo "[+] Seed praying name into the database completed" . PHP_EOL;

        return $this;
    }

    public function seedZones(): static
    {
        $zone_services = new ZoneService();
        $zone_services->getConnection();

        $data = [
            new Zone(null, 'JHR01'),
            new Zone(null, 'JHR02'),
            new Zone(null, 'JHR03'),
            new Zone(null, 'JHR04'),
            new Zone(null, 'KDH01'),
            new Zone(null, 'KDH02'),
            new Zone(null, 'KDH03'),
            new Zone(null, 'KDH04'),
            new Zone(null, 'KDH05'),
            new Zone(null, 'KDH06'),
            new Zone(null, 'KDH07'),
            new Zone(null, 'KTN01'),
            new Zone(null, 'KTN03'),
            new Zone(null, 'MLK01'),
            new Zone(null, 'NGS01'),
            new Zone(null, 'NGS02'),
            new Zone(null, 'WLY01'),
            new Zone(null, 'SWK02')
        ];

        foreach($data as $rs) {
            $zone_services->addZone($rs);
        }

        $zone_services->closeConnection();

        echo "[+] Seed zones into the database completed" . PHP_EOL;

        return $this;
    }

    public function seedBoxes(): static
    {
        $box_service = new BoxService();
        $box_service->getConnection();

        $data = [
            new Box(null, 'Orchard Tower', 17, 0),
            new Box(null, 'United Square', 18, 0),
            new Box(null, 'Thompson Plaza', 1, 0),
            new Box(null, 'Peranakan Place', 5, 0),
            new Box(null, 'Marina Boulevard', 14, 0)
        ];

        foreach($data as $rs) {
            $box_service->addBox($rs);
        }

        $box_service->closeConnection();

        echo "[+] Seed initial boxes into the database completed" . PHP_EOL;
        return $this;
    }

    public function seedSubscriberBoxes(): static
    {
        $service = new SubscriberBoxService();
        $service->getConnection();

        $data = [
            new SubscriberBox(1,1),
            new SubscriberBox(1,2),
            new SubscriberBox(2,3),
            new SubscriberBox(2,4),
            new SubscriberBox(2,5)
        ];

        foreach($data as $rs) {
            $service->addSubscriberBox($rs);
        }

        $service->closeConnection();
        echo "[+] Seed initial subscriber boxes into the database completed" . PHP_EOL;
        return $this;
    }
}
