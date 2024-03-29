<?php

namespace Khairu\Sholat\Services;

use Khairu\Sholat\Models\Box;
use Khairu\Sholat\Models\Database;
use PDOException;

/**
 * Class BoxService
 *
 * Handles operations related to the Box entity.
 *
 * @package Khairu\Sholat\Models
 */
class BoxService extends Database {
    /**
     * Add a new Box to the database.
     *
     * @param Box $box The Box object to add.
     * @throws PDOException If an error occurs while adding the Box.
     * @return int The ID of the last inserted Box.
     */
    public function addBox(Box $box): int
    {
        $sql = "INSERT INTO boxes (name, zone_id, has_voice_over) VALUES (:name, :zone_id, :has_voice_over)";
        $params = [
            ':name' => $box->name,
            ':zone_id' => $box->zone_id,
            ':has_voice_over' => $box->hasVoiceOver ? 1 : 0,
        ];

        try {
            $this->executeQuery($sql, $params);
            return (int)$this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Edit an existing Box in the database.
     *
     * @param Box $box The updated Box object.
     * @throws PDOException If an error occurs while editing the Box.
     */
    public function editBox(Box $box): void
    {
        $sql = "UPDATE boxes SET name = :name, zone_id = :zone_id, has_voice_over = :has_voice_over WHERE id = :id";
        $params = [
            ':id' => $box->id,
            ':name' => $box->name,
            ':zone_id' => $box->zone_id,
            ':has_voice_over' => $box->hasVoiceOver ? 1 : 0,
        ];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Delete a Box from the database.
     *
     * @param int $id The ID of the Box to delete.
     * @throws PDOException If an error occurs while deleting the Box.
     */
    public function deleteBox(int $id): void
    {
        $sql = "DELETE FROM boxes WHERE id = :id";
        $params = [':id' => $id];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }
}