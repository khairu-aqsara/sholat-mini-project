<?php

namespace Khairu\Sholat\Models;

/**
 * Represents the data structure for the MySQL view `praying_time_data`.
 */
class PrayingTimeData
{
    /**
     * @var string The praying date in 'YYYY-MM-DD' format.
     */
    public $praying_date;

    /**
     * @var string The praying time in 'HH:MM AM/PM' format.
     */
    public $praying_time;

    /**
     * @var string The praying name with date and format (e.g., "Name (MM-DD)").
     */
    public $praying_name_with_date;

    /**
     * @var string The praying name.
     */
    public $praying_name;

    /**
     * @var int The praying sequence.
     */
    public $praying_seq;

    /**
     * @var string The box name.
     */
    public $box;

    /**
     * @var string The zone name.
     */
    public $zone;

    /**
     * @var string The subscriber name.
     */
    public $subscriber;

    /**
     * @var int The subscriber ID.
     */
    public $subscriber_id;

    /**
     * @var int The box ID.
     */
    public $box_id;

    /**
     * Constructor to initialize the PrayingTimeData object.
     *
     * @param string $praying_date The praying date.
     * @param string $praying_time The praying time.
     * @param string $praying_name_with_date The praying name with date.
     * @param string $praying_name The praying name.
     * @param int $praying_seq The praying sequence.
     * @param string $box The box name.
     * @param string $zone The zone name.
     * @param string $subscriber The subscriber name.
     * @param int $subscriber_id The subscriber ID.
     * @param int $box_id The box ID.
     */
    public function __construct(
        string $praying_date,
        string $praying_time,
        string $praying_name_with_date,
        string $praying_name,
        int $praying_seq,
        string $box,
        string $zone,
        string $subscriber,
        int $subscriber_id,
        int $box_id)
    {
        $this->praying_date = $praying_date;
        $this->praying_time = $praying_time;
        $this->praying_name_with_date = $praying_name_with_date;
        $this->praying_name = $praying_name;
        $this->praying_seq = $praying_seq;
        $this->box = $box;
        $this->zone = $zone;
        $this->subscriber = $subscriber;
        $this->subscriber_id = $subscriber_id;
        $this->box_id = $box_id;
    }
}
