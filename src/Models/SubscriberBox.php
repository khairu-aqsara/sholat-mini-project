<?php

namespace Khairu\Sholat\Models;

/**
 * Represents a SubscriberBox entity (for the pivot table).
 */
class SubscriberBox
{
    /** @var int */
    public int $subscriberId;

    /** @var int */
    public int $boxId;

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