<?php
require_once('vendor/autoload.php');

// Example usage:
use Khairu\Sholat\Exceptions\ExceptionLogger;

try {
    // Code that may throw an exception
    throw new ExceptionLogger("An error occurred!");
} catch (ExceptionLogger $e) {
    $e->report(false, "Error Occured when trying to process data", 1, 'JHR01'); // Send error report via email using mail function with SMTP headers
    echo "Error reported and email sent.";
}