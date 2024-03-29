<?php

namespace Khairu\Sholat\Models;

/**
 * Represents a PrayingName entity.
 */
class PrayingName
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $json_key;

    /** @var int */
    public $prayingSeq;

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