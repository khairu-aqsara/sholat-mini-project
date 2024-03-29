<?php

namespace Khairu\Sholat\Exceptions;

class DatabaseException extends \PDOException
{
    public static function logException($e): void
    {
        error_log("Database Connection Error: " . $e->getMessage());
        $logger = new ExceptionLogger();
        $logger->report(true, $e->getMessage());
    }
}