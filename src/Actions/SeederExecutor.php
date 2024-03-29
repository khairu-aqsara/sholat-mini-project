<?php

namespace Khairu\Sholat\Actions;

use Khairu\Sholat\Models\Database;

/**
 * Class SeederExecutor
 * Executes the Seeder class for database seeding operations.
 */
class SeederExecutor
{
    /**
     * Execute the Seeder class to perform database seeding.
     */
    public static function executeSeeder(): void
    {
        // Create an instance of the Database class
        $database = new Database();

        // Establish a database connection
        $database->getConnection();

        // Create an instance of the Seeder class
        $seeder = new Seeder($database);

        // Truncate tables and seed data using Seeder class methods
        $seeder->truncateTables();

        echo "[!] All Tables has been truncated." . PHP_EOL;

        // Close the database connection instance after truncate the tables
        // Seeder will use Own Services Database
        $database->closeConnection();

        $seeder->seedPrayingName()
            ->seedZones()
            ->seedSubscribers()
            ->seedBoxes()
            ->seedSubscriberBoxes();
    }
}