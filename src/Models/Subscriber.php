<?php

namespace Khairu\Sholat\Models;

/**
 * Represents a Subscriber entity.
 */
class Subscriber
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /**
     * Subscriber constructor.
     * @param int|null $id
     * @param string $name
     */
    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
