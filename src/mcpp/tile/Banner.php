<?php

namespace mcpp\tile;

use mcpp\level\format\FullChunk;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;

class Banner extends Spawnable {

	private $baseColor = 0;

	public function __construct(FullChunk $chunk, Compound $nbt) {
		parent::__construct($chunk, $nbt);
		if (isset($this->namedtag->Base)) {
			$this->baseColor = (int) $this->namedtag["Base"];
		}
	}

	public function saveNBT() {
		parent::saveNBT();
		$this->namedtag->Base = new IntTag("Base", $this->baseColor);
	}

	public function getSpawnCompound() {
		return new Compound("", [
			new StringTag("id", Tile::BANNER),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			new IntTag("Base", $this->baseColor)
		]);
	}

}
