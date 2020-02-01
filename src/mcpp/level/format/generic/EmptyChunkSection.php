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

use mcpp\level\format\ChunkSection;
use mcpp\utils\ChunkException;

/**
 * Stub used to detect empty chunks
 */
class EmptyChunkSection implements ChunkSection
{
    private $y;

    public function __construct($y)
    {
        $this->y = $y;
    }

    final public function getY()
    {
        return $this->y;
    }

    final public function getBlockId($x, $y, $z)
    {
        return 0;
    }

    final public function getBlockIdColumn($x, $z)
    {
        return "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00";
    }

    final public function getBlockDataColumn($x, $z)
    {
        return "\x00\x00\x00\x00\x00\x00\x00\x00";
    }

    final public function getFullBlock($x, $y, $z)
    {
        return 0;
    }

    final public function getBlock($x, $y, $z, &$id = null, &$meta = null)
    {
        $id = 0;
        $meta = 0;
    }

    final public function setBlock($x, $y, $z, $id = null, $meta = null)
    {
        throw new ChunkException("Tried to modify an empty Chunk");
    }

    public function getIdArray()
    {
        return str_repeat("\x00", 4096);
    }

    public function getDataArray()
    {
        return str_repeat("\x00", 2048);
    }

    public function getSkyLightArray()
    {
        return str_repeat("\xff", 2048);
    }

    public function getLightArray()
    {
        return str_repeat("\x00", 2048);
    }

    final public function setBlockId($x, $y, $z, $id)
    {
        throw new ChunkException("Tried to modify an empty Chunk");
    }

    final public function getBlockData($x, $y, $z)
    {
        return 0;
    }

    final public function setBlockData($x, $y, $z, $data)
    {
        throw new ChunkException("Tried to modify an empty Chunk");
    }
}