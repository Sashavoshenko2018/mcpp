<?php

namespace mcpp\tile;

use mcpp\level\format\FullChunk;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;

class Skull extends Spawnable{
	
	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->SkullType)){
			$nbt->SkullType = new StringTag("SkullType", 0);
		}
		parent::__construct($chunk, $nbt);
	}
	
	public function saveNBT(){
		parent::saveNBT();
		unset($this->namedtag->Creator);
	}
	
	public function getSpawnCompound(){
		return new Compound("", [
			new StringTag("id", Tile::SKULL),
			$this->namedtag->SkullType,
			new IntTag("x", (int)$this->x),
			new IntTag("y", (int)$this->y),
			new IntTag("z", (int)$this->z),
			$this->namedtag->Rot
		]);
	}
	public function getSkullType(){
		return $this->namedtag["SkullType"];
	}
}
