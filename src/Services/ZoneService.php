<?php

namespace Khairu\Sholat\Services;

use Khairu\Sholat\Models\Database;
use Khairu\Sholat\Models\Zone;
use PDOException;

/**
 * Class ZoneService
 *
 * Handles operations related to the Zone entity.
 *
 * @package Khairu\Sholat\Models
 */
class ZoneService extends Database {
    /**
     * Add a new Zone to the database.
     *
     * @param Zone $zone The Zone object to add.
     * @throws PDOException If an error occurs while adding the Zone.
     */
    public function addZone(Zone $zone): int
    {
        $sql = "INSERT INTO zones (name) VALUES (:name)";
        $params = [
            ':name' => $zone->name,
        ];

        try {
            $this->executeQuery($sql, $params);
            return (int)$this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Edit an existing Zone in the database.
     *
     * @param Zone $zone The updated Zone object.
     * @throws PDOException If an error occurs while editing the Zone.
     */
    public function editZone(Zone $zone): void
    {
        $sql = "UPDATE zones SET name = :name WHERE id = :id";
        $params = [
            ':id' => $zone->id,
            ':name' => $zone->name,
        ];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Delete a Zone from the database.
     *
     * @param int $id The ID of the Zone to delete.
     * @throws PDOException If an error occurs while deleting the Zone.
     */
    public function deleteZone(int $id): void
    {
        $sql = "DELETE FROM zones WHERE id = :id";
        $params = [':id' => $id];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }
}