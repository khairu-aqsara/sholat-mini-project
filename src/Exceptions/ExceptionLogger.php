<?php

namespace Khairu\Sholat\Exceptions;

use Exception;

class ExceptionLogger extends Exception
{
    public function report(bool $isDatabase, string $error, ?int $boxId=null, ?string $zone=''): void
    {
        $emailContent = "";

        if(!$isDatabase) {
            // Compose email content for Non Database
            if(!is_null($boxId))
                $emailContent .= "Error occurred in box ID: $boxId\n";

            if(!empty($zone))
                $emailContent .= "Prayer time zone: $zone\n";

            $emailContent .= "Error message: $error";
        }else{
            $emailContent .= $error;
        }

        // SMTP server settings
        ini_set('smtp_port', 1025);
        $smtpUsername = '';
        $smtpPassword = '';
        $smtpHost = 'localhost';
        $smtpPort = 1025;

        // SMTP headers
        $headers = "From: boxsystem@myserver.com\r\n";
        $headers .= "Reply-To: boxsystem@myserver.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";

        // Additional SMTP headers for sending via SMTP
        $headers .= "X-SMTPAPI: {}\r\n";
        $headers .= "SMTPAuth: true\r\n";
        $headers .= "Username: $smtpUsername\r\n";
        $headers .= "Password: $smtpPassword\r\n";
        $headers .= "SMTPSecure: tls\r\n";
        $headers .= "Host: $smtpHost\r\n";
        $headers .= "Port: $smtpPort\r\n";

        // Send email
        $to = 'phu@expressinmusic.com';
        $subject = 'Error Reporting';

        // Send email using mail function with SMTP headers
        mail($to, $subject, $emailContent, $headers);
    }
}