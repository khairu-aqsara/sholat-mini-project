<?php

namespace Khairu\Sholat\Services;

use Khairu\Sholat\Models\Database;
use Khairu\Sholat\Models\PrayingTimeData;
use Khairu\Sholat\Models\Song;
use PDO;
use PDOException;

class SongService extends Database
{
    public function addSong(Song $song): int {
        $sql = "INSERT INTO songs (praying_id, box_id, praying_time) VALUES(:praying_id, :box_id, :praying_time)";
        $params = [
            ':praying_id' => $song->prayingId,
            ':box_id' => $song->boxId,
            ':praying_time' => $song->prayingTime,
        ];

        try {
            if($this->checkIsDataExists($song)) {
                $this->executeQuery($sql, $params);
                return (int)$this->conn->lastInsertId();
            }

            return 0;
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    public function addBulkSongs(array $songs): void
    {
        try{
            // Start a transaction
            $this->beginTransaction();

            // Prepare the INSERT statement
            $sql = "INSERT INTO songs (praying_id, box_id, praying_time) VALUES(:praying_id, :box_id, :praying_time)";
            $stmt = $this->conn->prepare($sql);

            // Iterate through the data and execute the prepared statement for each row
            foreach($songs as $song) {
                // Bind parameters
                $stmt->bindParam(':praying_id', $song->prayingId, PDO::PARAM_INT);
                $stmt->bindParam(':box_id', $song->boxId, PDO::PARAM_INT);
                $stmt->bindParam(':praying_time', $song->prayingTime);
                if(!$this->checkIsDataExists($song)) {
                    $stmt->execute();
                }
            }

            // Commit the transaction if all INSERT are successful
            $this->commit();
        }catch (PDOException $e) {
            $this->rollback();
            $this->logException($e);
        }
    }

    public function checkIsDataExists(Song $song): bool {

        $sql = "SELECT COUNT(*) FROM songs 
                WHERE box_id = :box_id 
                AND praying_time = :praying_time 
                AND praying_id = :praying_id";

        $params = [
            ':praying_id' => $song->prayingId,
            ':box_id' => $song->boxId,
            ':praying_time' => $song->prayingTime,
        ];

        try {
            $stmt = $this->executeQuery($sql, $params);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    public function getAllPrayingData() {
        $sql = "SELECT * from praying_time_data";
        $response = [];
        try {
            $stmt = $this->executeQuery($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $return = new PrayingTimeData(
                    $row['praying_date'],
                    $row['praying_time'],
                    $row['praying_name_with_date'],
                    $row['praying_name'],
                    $row['praying_seq'],
                    $row['box'],
                    $row['zone'],
                    $row['subscriber'],
                    $row['subscriber_id'],
                    $row['box_id']
                );

                $response[] = $return;
            }

            return $response;
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    public function getTodayData(int $boxId, string $date): array
    {
        $sql = "SELECT * FROM praying_time_data where box_id = :box_id AND praying_date = :praying_date";
        $params = [
            ':box_id' => $boxId,
            ':praying_date' => $date
        ];

        $response = [];

        $stmt = $this->executeQuery($sql, $params);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $return = new PrayingTimeData(
                $row['praying_date'],
                $row['praying_time'],
                $row['praying_name_with_date'],
                $row['praying_name'],
                $row['praying_seq'],
                $row['box'],
                $row['zone'],
                $row['subscriber'],
                $row['subscriber_id'],
                $row['box_id']
            );

            $response[] = $return;
        }

        return $response;
    }

    public function isTimeToPray(array $data) {
        return array_map(fn($value) => $value->praying_time, $data);
    }
}