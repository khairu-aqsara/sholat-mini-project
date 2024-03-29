[![PHP Unit Tests](https://github.com/khairu-aqsara/sholat-mini-project/actions/workflows/php-tests.yml/badge.svg)](https://github.com/khairu-aqsara/sholat-mini-project/actions/workflows/php-tests.yml)
# Mini Project Sholat Time

This project focuses on prayer times and is currently limited to the Malaysian time zone. It automatically plays the Adzan when it's time for prayer

![img.png](img.png)

## ERD
```mermaid
erDiagram
    SUBSCRIBERS {
        int id
        varchar(255) name
    }

    BOXES {
        int id
        varchar(255) name
        int zone_id
        boolean has_voice_over
    }

    SUBSCRIBER_BOXES {
        int subscriber_id
        int box_id
    }

    PRAYING_NAME {
        int id
        varchar(255) name
        int praying_seq
    }

    SONGS {
        int id
        int praying_id
        int box_id
        datetime praying_time
    }

    ZONES {
        string id
        string name
    }

    SUBSCRIBERS ||..|{ SUBSCRIBER_BOXES : "Has"
    BOXES ||..|{ SUBSCRIBER_BOXES : "Has"
    SONGS }o..o{ PRAYING_NAME: "Has"
    BOXES }o..|{ SONGS: "Has Many"
    BOXES }o..o{ ZONES: "Has"


```

## Flow Process
```mermaid
flowchart TD

    subgraph "System"
        subgraph "Subscribers"
            Subscriber -->|has many| Box
        end

        subgraph "Boxes"
            Box -->|has many| VoiceOver
            Box -->|in specific prayer zone| Zone
            Box -->|has prayer time enabled| VoiceOverScript
        end

        subgraph "Prayer Time"
            subgraph "Government Website"
                Website[https://www.esolat.gov.my] -->|retrieve prayer time| Application[Application]
            end

            Application -->|update 7 days of voiceovers| VoiceOverScript
        end

        subgraph "Error Handling"
            Application -->|error| Email[Send Email]
        end
    end

    VoiceOverScript -->|play voiceover| VoiceOver
    Email -->|contains| BoxId
    Email -->|contains| PrayerTimeZone
    Email -->|contains| ErrorMessage

```

## Installation Guide

### Requirement
```
php 8.2
```

first thing first, we need to install all dependency by running

```bash
composer install
```

This application does not utilize migration scripts. Follow these steps to set it up:

1. Manually create a table by executing the `table.sql` file provided.
2. Modify the database connection configuration in `src/Models/Database.php` as follows:
```php
#src/Models/Database.php
private string $host = 'localhost';
private string $db_name = 'sholat';
private string $username = 'root';
private string $password = 'root';
```
After configuring the database, run the seeder script to populate the database with example data:

```php
php reset.php
```

## Fetching Sholat Time from the Endpoint
To retrieve Sholat time from the specified endpoint, you can manually run the following script or schedule it as a cron job to run once every 7 days:

```php
php sync.php
```

This command will read the Subscriber table, identify all boxes associated with each subscriber, and fetch the prayer time data based on the box's prayer zone.

## Testing
to run the unit test please run the following command
```bash
./vendor/bin/pest
```
![img_1.png](img_1.png)
