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

use mcpp\level\format\FullChunk;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;

class Sign extends Spawnable
{
    public function __construct(FullChunk $chunk, Compound $nbt)
    {
        if(!isset($nbt->Text1)){
            $nbt->Text1 = new StringTag("Text1", "");
        }
        if(!isset($nbt->Text2)){
            $nbt->Text2 = new StringTag("Text2", "");
        }
        if(!isset($nbt->Text3)){
            $nbt->Text3 = new StringTag("Text3", "");
        }
        if(!isset($nbt->Text4)){
            $nbt->Text4 = new StringTag("Text4", "");
        }

        parent::__construct($chunk, $nbt);
    }

    public function saveNBT()
    {
        parent::saveNBT();
        unset($this->namedtag->Creator);
    }

    public function setText($line1 = "", $line2 = "", $line3 = "", $line4 = "")
    {
        $this->namedtag->Text1 = new StringTag("Text1", $line1);
        $this->namedtag->Text2 = new StringTag("Text2", $line2);
        $this->namedtag->Text3 = new StringTag("Text3", $line3);
        $this->namedtag->Text4 = new StringTag("Text4", $line4);
        $this->spawnToAll();
        $this->getLevel()->chunkCacheClear($this->x >> 4, $this->z >> 4);
        return true;
    }

    public function getText()
    {
        return [
            $this->namedtag["Text1"],
            $this->namedtag["Text2"],
            $this->namedtag["Text3"],
            $this->namedtag["Text4"]
        ];
    }

    public function getSpawnCompound()
    {
        return new Compound("", [
            new StringTag("id", Tile::SIGN),
            new StringTag("Text", $this->namedtag->Text1 . "\n" . $this->namedtag->Text2 . "\n" . $this->namedtag->Text3 . "\n" . $this->namedtag->Text4),
            new IntTag("x", (int)$this->x),
            new IntTag("y", (int)$this->y),
            new IntTag("z", (int)$this->z)
        ]);
    }
}