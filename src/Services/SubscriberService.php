<?php

namespace Khairu\Sholat\Services;

use Khairu\Sholat\Models\Database;
use Khairu\Sholat\Models\Subscriber;
use PDOException;

/**
 * Class SubscriberDatabase
 *
 * Handles database operations related to Subscriber entities.
 *
 * @package Khairu\Sholat\Models
 */
class SubscriberService extends Database {
    /**
     * Add a new Subscriber to the database and return the last inserted ID.
     *
     * @param Subscriber $subscriber The Subscriber object to add.
     * @return int The ID of the last inserted Subscriber.
     * @throws PDOException If an error occurs while adding the Subscriber.
     */
    public function addSubscriber(Subscriber $subscriber): int {
        $sql = "INSERT INTO subscribers (name) VALUES (:name)";
        $params = [
            ':name' => $subscriber->name,
        ];

        try {
            $this->executeQuery($sql, $params);
            return (int)$this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Edit an existing Subscriber in the database.
     *
     * @param Subscriber $subscriber The updated Subscriber object.
     * @throws PDOException If an error occurs while editing the Subscriber.
     */
    public function editSubscriber(Subscriber $subscriber): void
    {
        $sql = "UPDATE subscribers SET name = :name WHERE id = :id";
        $params = [
            ':id' => $subscriber->id,
            ':name' => $subscriber->name,
        ];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Delete a Subscriber from the database.
     *
     * @param int $id The ID of the Subscriber to delete.
     * @throws PDOException If an error occurs while deleting the Subscriber.
     */
    public function deleteSubscriber(int $id): void
    {
        $sql = "DELETE FROM subscribers WHERE id = :id";
        $params = [':id' => $id];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }
}