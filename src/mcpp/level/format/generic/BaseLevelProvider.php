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

namespace mcpp\level\format\generic;

use mcpp\level\format\LevelProvider;
use mcpp\level\Level;
use mcpp\math\Vector3;
use mcpp\nbt\NBT;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\utils\LevelException;

abstract class BaseLevelProvider implements LevelProvider
{
    /** @var Level */
    protected $level;
    /** @var string */
    protected $path;
    /** @var Compound */
    protected $levelData;

    public function __construct(Level $level, $path)
    {
        $this->level = $level;
        $this->path = $path;
        if(!file_exists($this->path)){
            mkdir($this->path, 0777, true);
        }
        $nbt = new NBT(NBT::BIG_ENDIAN);
        $nbt->readCompressed(file_get_contents($this->getPath() . "level.dat"));
        $levelData = $nbt->getData();
        if($levelData->Data instanceof Compound){
            $this->levelData = $levelData->Data;
        }else{
            throw new LevelException("Invalid level.dat");
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getServer()
    {
        return $this->level->getServer();
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getName()
    {
        return $this->levelData["LevelName"];
    }

    public function getTime()
    {
        return $this->levelData["Time"];
    }

    public function setTime($value)
    {
        $this->levelData->Time = new IntTag("Time", (int)$value);
    }

    public function getSeed()
    {
        return $this->levelData["RandomSeed"];
    }

    public function setSeed($value)
    {
        $this->levelData->RandomSeed = new IntTag("RandomSeed", (int)$value);
    }

    public function getSpawn()
    {
        return new Vector3((float)$this->levelData["SpawnX"], (float)$this->levelData["SpawnY"], (float)$this->levelData["SpawnZ"]);
    }

    public function setSpawn(Vector3 $pos)
    {
        $this->levelData->SpawnX = new IntTag("SpawnX", (int)$pos->x);
        $this->levelData->SpawnY = new IntTag("SpawnY", (int)$pos->y);
        $this->levelData->SpawnZ = new IntTag("SpawnZ", (int)$pos->z);
    }

    public function doGarbageCollection()
    {
    }

    /**
     * @return Compound
     */
    public function getLevelData()
    {
        return $this->levelData;
    }

    public function saveLevelData()
    {
        $nbt = new NBT(NBT::BIG_ENDIAN);
        $nbt->setData(new Compound("", [
            "Data" => $this->levelData
        ]));
        $buffer = $nbt->writeCompressed();
        file_put_contents($this->getPath() . "level.dat", $buffer);
    }
}