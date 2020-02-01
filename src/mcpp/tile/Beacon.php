<?php

namespace mcpp\tile;

use mcpp\level\format\FullChunk;
use mcpp\nbt\tag\ByteTag;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;

class Beacon extends Spawnable
{
    private $primary = 0;
    private $secondary = 0;

    public function __construct(FullChunk $chunk, Compound $nbt)
    {
        parent::__construct($chunk, $nbt);
        if(isset($this->namedtag->primary)){
            $this->primary = (int)$this->namedtag["primary"];
        }
        if(isset($this->namedtag->secondary)){
            $this->secondary = (int)$this->namedtag["secondary"];
        }
    }

    public function getSpawnCompound()
    {
        return new Compound("", [
            new StringTag("id", Tile::BEACON),
            new IntTag("x", (int)$this->x),
            new IntTag("y", (int)$this->y),
            new IntTag("z", (int)$this->z),
            new IntTag("primary", (int)$this->primary),
            new IntTag("secondary", (int)$this->secondary),
            new ByteTag("isMovable", (int)$this->namedtag["isMovable"])
        ]);
    }

    public function saveNBT()
    {
        parent::saveNBT();
        $this->namedtag->primary = new IntTag("primary", $this->primary);
        $this->namedtag->secondary = new IntTag("secondary", $this->secondary);
    }
}
