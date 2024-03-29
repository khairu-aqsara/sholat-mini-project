<?php

namespace Khairu\Sholat\Services;

use Khairu\Sholat\Models\Database;
use Khairu\Sholat\Models\PrayingName;
use PDO;
use PDOException;

/**
 * Class PrayingNameService
 *
 * Handles operations related to the PrayingName entity.
 *
 * @package Khairu\Sholat\Models
 */
class PrayingNameService extends Database {
    /**
     * Add a new PrayingName to the database.
     * @param PrayingName $prayingName The PrayingName object to add.
     * @return int The ID of the last inserted Praying Name.
     */
    public function addPrayingName(PrayingName $prayingName): int
    {
        $sql = "INSERT INTO praying_name (name, json_key, praying_seq) VALUES (:name, :json_key, :praying_seq)";
        $params = [
            ':name' => $prayingName->name,
            ':json_key' => $prayingName->json_key,
            ':praying_seq' => $prayingName->prayingSeq,
        ];

        try {
            $this->executeQuery($sql, $params);
            return (int)$this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    public function getPrayingByJsonKey($key) {
        $sql = "SELECT * from praying_name WHERE json_key = :json_key";
        $params = [
            ':json_key' => $key
        ];

        try {
            $stmt = $this->executeQuery($sql, $params);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Edit an existing PrayingName in the database.
     *
     * @param PrayingName $prayingName The updated PrayingName object.
     */
    public function editPrayingName(PrayingName $prayingName): void
    {
        $sql = "UPDATE praying_name SET name = :name, praying_seq = :praying_seq WHERE id = :id";
        $params = [
            ':id' => $prayingName->id,
            ':name' => $prayingName->name,
            ':praying_seq' => $prayingName->prayingSeq,
        ];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Delete a PrayingName from the database.
     *
     * @param int $id The ID of the PrayingName to delete.
     */
    public function deletePrayingName(int $id): void
    {
        $sql = "DELETE FROM praying_name WHERE id = :id";
        $params = [':id' => $id];

        try {
            $this->executeQuery($sql, $params);
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }
}