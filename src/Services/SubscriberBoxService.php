<?php

namespace Khairu\Sholat\Services;

use Khairu\Sholat\Models\Database;
use Khairu\Sholat\Models\SubscriberBox;
use Khairu\Sholat\Models\SubscriberWithBoxes;
use PDO;
use PDOException;

/**
 * Class SubscriberBoxService
 *
 * Handles operations related to the SubscriberBox entity (for the pivot table).
 *
 * @package Khairu\Sholat\Models
 */
class SubscriberBoxService extends Database {
    /**
     * Add a new SubscriberBox relationship to the database (for the pivot table).
     *
     * @param SubscriberBox $subscriberBox The SubscriberBox object representing the relationship.
     * @throws PDOException If an error occurs while adding the SubscriberBox relationship.
     */
    public function addSubscriberBox(SubscriberBox $subscriberBox): void
    {
        $sql = "INSERT INTO subscriber_boxes (subscriber_id, box_id) VALUES (:subscriber_id, :box_id)";
        $params = [
            ':subscriber_id' => $subscriberBox->subscriberId,
            ':box_id' => $subscriberBox->boxId,
        ];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Remove a SubscriberBox relationship from the database (for the pivot table).
     *
     * @param int $subscriberId The ID of the subscriber in the relationship.
     * @param int $boxId The ID of the box in the relationship.
     * @throws PDOException If an error occurs while removing the SubscriberBox relationship.
     */
    public function removeSubscriberBox(int $subscriberId, int $boxId): void
    {
        $sql = "DELETE FROM subscriber_boxes WHERE subscriber_id = :subscriber_id AND box_id = :box_id";
        $params = [
            ':subscriber_id' => $subscriberId,
            ':box_id' => $boxId,
        ];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Get all Subscriber With Box records from the database.
     *
     * @return array An array of SubscriberBox objects.
     * @throws PDOException If an error occurs while fetching SubscriberBox records.
     */
    public function getAllSubscriberBoxes(): array {
        $sql ="SELECT * FROM subscriber_with_boxes";
        $subscriberBoxes = [];

        try {
            $stmt = $this->executeQuery($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Create an instance of SubscriberWithBoxes for each row
                $subscriberBox = new SubscriberWithBoxes(
                    $row['subscriber_id'],
                    $row['box_id'],
                    $row['zone'],
                    $row['subscriber'],
                    $row['boxes'],
                    $row['has_voice_over'],
                    $row['zone_id']
                );
                // Add the instance to the array
                $subscriberBoxes[] = $subscriberBox;
            }

            return $subscriberBoxes;

        } catch (PDOException $e) {
            $this->logException($e);
        }
    }
}