<?php

namespace Khairu\Sholat\Models;

/**
 * Class SubscriberBoxModel
 * Represents a subscriber box entity with properties mapped from a database query.
 */
class SubscriberWithBoxes
{
    /**
     * @var int The ID of the subscriber.
     */
    public $subscriber_id;

    /**
     * @var int The ID of the box.
     */
    public $box_id;

    /**
     * @var string The name of the zone.
     */
    public $zone;

    /**
     * @var string The name of the subscriber.
     */
    public $subscriber;

    /**
     * @var string The name of the box.
     */
    public $boxes;

    /**
     * @var bool Whether the box has a voice-over.
     */
    public $has_voice_over;

    /**
     * @var int The ID of the zones.
     */
    public $zone_id;

    /**
     * SubscriberBoxModel constructor.
     * @param int $subscriber_id The ID of the subscriber.
     * @param int $box_id The ID of the box.
     * @param string $zone The name of the zone.
     * @param string $subscriber The name of the subscriber.
     * @param string $boxes The name of the box.
     * @param bool $has_voice_over Whether the box has a voice-over.
     * @param int $zone_id The ID of the Zone.
     */
    public function __construct(int $subscriber_id, int $box_id, string $zone, string $subscriber, string $boxes, bool $has_voice_over, int $zone_id)
    {
        $this->subscriber_id = $subscriber_id;
        $this->box_id = $box_id;
        $this->zone = $zone;
        $this->subscriber = $subscriber;
        $this->boxes = $boxes;
        $this->has_voice_over = $has_voice_over;
        $this->zone_id = $zone_id;
    }
}