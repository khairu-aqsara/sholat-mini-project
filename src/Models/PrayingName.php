<?php

namespace Khairu\Sholat\Models;

/**
 * Represents a PrayingName entity.
 */
class PrayingName
{
    /** @var int */
    public ?int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $json_key;

    /** @var int */
    public int $prayingSeq;

    /**
     * PrayingName constructor.
     * @param int|null $id
     * @param string $name
     * @param int $prayingSeq
     */
    public function __construct(?int $id, string $name, string $json_key, int $prayingSeq)
    {
        $this->id = $id;
        $this->name = $name;
        $this->json_key = $json_key;
        $this->prayingSeq = $prayingSeq;
    }
}