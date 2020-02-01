<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace mcpp\tile;

use mcpp\item\Item;
use mcpp\level\format\FullChunk;
use mcpp\nbt\NBT;
use mcpp\nbt\tag\ByteTag;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\FloatTag;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;

class ItemFrame extends Spawnable {

	/** @var Item */
	private $item = null;

	public function __construct(FullChunk $chunk, Compound $nbt) {
		parent::__construct($chunk, $nbt);
		if (isset($this->namedtag->Item)) {
			$this->item = NBT::getItemHelper($this->namedtag["Item"]);
		} else {
			$this->item = Item::get(Item::AIR);
		}
	}

	public function getSpawnCompound() {
		return new Compound("", [
			new StringTag("id", Tile::ITEM_FRAME),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			new FloatTag("ItemDropChance", 0),
			new ByteTag("ItemRotation", 0),
			NBT::putItemHelper($this->item)
		]);
	}
}