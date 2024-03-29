<?php

namespace Khairu\Sholat\Models;

/**
 * Represents a Box entity.
 */
class Box
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var int */
    public $zone_id;

    /** @var bool */
    public $hasVoiceOver;

    /**
     * Box constructor.
     * @param int|null $id
     * @param string $name
     * @param int $zone_id
     * @param bool $hasVoiceOver
     */
    public function __construct(?int $id, string $name, int $zone_id, bool $hasVoiceOver)
    {
        $this->id = $id;
        $this->name = $name;
        $this->zone_id = $zone_id;
        $this->hasVoiceOver = $hasVoiceOver;
    }
}
