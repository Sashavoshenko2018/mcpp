<?php

namespace mcpp\tile;

use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;
use mcpp\nbt\tag\ByteTag;

class Bed extends Spawnable {

	public function getSpawnCompound() {
		return new Compound("", [
			new StringTag("id", Tile::BED),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			new ByteTag("color", (int) $this->namedtag["color"]),
			new ByteTag("isMovable", (int) $this->namedtag["isMovable"])
		]);
	}

}
