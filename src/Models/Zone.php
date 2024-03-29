<?php

namespace Khairu\Sholat\Models;

/**
 * Represents a Zone entity.
 */
class Zone
{
    /** @var int */
    public ?int $id;

    /** @var string */
    public string $name;

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