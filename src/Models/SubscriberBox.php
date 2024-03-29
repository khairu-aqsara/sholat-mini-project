<?php

namespace Khairu\Sholat\Models;

/**
 * Represents a SubscriberBox entity (for the pivot table).
 */
class SubscriberBox
{
    /** @var int */
    public $subscriberId;

    /** @var int */
    public $boxId;

    /**
     * SubscriberBox constructor.
     * @param int $subscriberId
     * @param int $boxId
     */
    public function __construct(int $subscriberId, int $boxId)
    {
        $this->subscriberId = $subscriberId;
        $this->boxId = $boxId;
    }
}