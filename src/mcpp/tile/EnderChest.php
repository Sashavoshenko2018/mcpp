<?php

namespace mcpp\tile;

use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;

class EnderChest extends Spawnable  {
    
    public function getSpawnCompound(){
        $compound = new Compound("", [
            new StringTag("id", Tile::ENDER_CHEST),
            new IntTag("x", (int) $this->x),
            new IntTag("y", (int) $this->y),
            new IntTag("z", (int) $this->z)
        ]);

		if($this->hasName()){
			$compound->CustomName = $this->namedtag->CustomName;
		}

		return $compound;
	}
    
    public function hasName(){
		return isset($this->namedtag->CustomName);
	}
    
}
