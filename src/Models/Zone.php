<?php

namespace Khairu\Sholat\Models;

/**
 * Represents a Zone entity.
 */
class Zone
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /**
     * PrayingName constructor.
     * @param int|null $id
     * @param string $name
     */
    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}