<?php

namespace mcpp\tile;

use mcpp\nbt\tag\ByteTag;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\ShortTag;
use mcpp\nbt\tag\StringTag;
use mcpp\tile\Spawnable;

class Cauldron extends Spawnable {
	
	/** @todo add potionId */
	/** @todo add splash potion checking */
	/** @todo add isMovable logic */
	
	public function getSpawnCompound() {
		$compound = new Compound("", [
            new StringTag("id", Tile::CAULDRON),
            new IntTag("x", (int) $this->x),
            new IntTag("y", (int) $this->y),
            new IntTag("z", (int) $this->z),
            new ShortTag("PotionId", -1),
            new ByteTag("SplashPotion", 0),
            new ByteTag("isMovable", 1),
        ]);

		return $compound;
	}
	
}
