<?php

namespace Khairu\Sholat\Models;

use DateTime;

/**
 * Represents a Song entity.
 */
class Song
{
    /** @var int */
    public int $id;

    /** @var int */
    public int $prayingId;

    /** @var int */
    public int $boxId;

    /** @var string */
    public string $prayingTime;

    /**
     * Song constructor.
     * @param int|null $id
     * @param int $prayingId
     * @param int $boxId
     * @param string $prayingTime
     */
    public function __construct(?int $id, int $prayingId, int $boxId, string $prayingTime)
    {
        $this->id = $id;
        $this->prayingId = $prayingId;
        $this->boxId = $boxId;
        $this->prayingTime = $prayingTime;
    }
}
