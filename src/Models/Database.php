<?php

namespace Khairu\Sholat\Models;

use Khairu\Sholat\Exceptions\DatabaseException;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Class Database
 *
 * Represents a PDO database connection
 *
 * @package Khairu\Sholat\Models
 */
class Database {
    private string $host = 'localhost';
    private string $db_name = 'sholat';
    private string $username = 'root';
    private string $password = 'root';
    public ?PDO $conn = null;

    /**
     * Database constructor.
     *
     * @param PDO|null $pdo An optional PDO instance to use instead of creating a new connection.
     */
    public function __construct(?PDO $pdo = null) {
        $this->conn = $pdo;
    }

    /**
     * Get the PDO database connection.
     *
     * If a PDO instance is provided during construction, it will be used.
     * Otherwise, a new PDO connection will be established.
     *
     * @return PDO The PDO database connection.
     * @throws DatabaseException If a database connection error occurs.
     */
    public function getConnection(): PDO {
        if ($this->conn instanceof PDO) {
            return $this->conn;
        }

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            $this->logException($e);
        }

        return $this->conn;
    }

    /**
     * Execute a SQL query with optional parameters.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params An associative array of parameters for prepared statements (optional).
     * @return PDOStatement The prepared statement object.
     * @throws PDOException If an error occurs during query execution.
     */
    public function executeQuery(string $sql, array $params = []): PDOStatement {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            $this->logException($e);
        }
    }

    /**
     * Begin a transaction.
     *
     * @return bool True on success, false on failure.
     */
    public function beginTransaction(): bool {
        return $this->conn->beginTransaction();
    }

    /**
     * Commit the current transaction.
     *
     * @return bool True on success, false on failure.
     */
    public function commit(): bool {
        return $this->conn->commit();
    }

    /**
     * Roll back the current transaction.
     *
     * @return bool True on success, false on failure.
     */
    public function rollback(): bool {
        return $this->conn->rollBack();
    }

    /**
     * Close the database connection.
     */
    public function closeConnection(): void
    {
        $this->conn = null;
    }

    /**
     * Log a PDOException.
     *
     * This method is intended to be overridden in subclasses for actual logging implementation.
     *
     * @param PDOException $e The PDOException instance to log.
     */
    protected function logException(PDOException $e): void
    {
        DatabaseException::logException($e);
        throw new DatabaseException($e->getMessage());
    }
}
