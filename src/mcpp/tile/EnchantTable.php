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

use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;

class EnchantTable extends Spawnable implements Nameable
{
    public function getName()
    {
        return isset($this->namedtag->CustomName) ? $this->namedtag->CustomName->getValue() : "Enchanting Table";
    }

    public function hasName()
    {
        return isset($this->namedtag->CustomName);
    }

    public function setName($str)
    {
        if($str === ""){
            unset($this->namedtag->CustomName);
            return;
        }

        $this->namedtag->CustomName = new StringTag("CustomName", $str);
    }

    public function getSpawnCompound()
    {
        $c = new Compound("", [
            new StringTag("id", Tile::ENCHANT_TABLE),
            new IntTag("x", (int)$this->x),
            new IntTag("y", (int)$this->y),
            new IntTag("z", (int)$this->z)
        ]);

        if($this->hasName()){
            $c->CustomName = $this->namedtag->CustomName;
        }

        return $c;
    }
}
