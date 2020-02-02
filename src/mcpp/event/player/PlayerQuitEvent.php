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
 * @link   http://www.pocketmine.net/
 *
 *
 */

namespace mcpp\event\player;

use mcpp\Player;

/**
 * Called when a player leaves the server
 */
class PlayerQuitEvent extends PlayerEvent
{
    public static $handlerList = null;
    /** @var string */
    protected $quitMessage;
    protected $quitReason;
    protected $quitLog;

    public function __construct(Player $player, $quitMessage, $quitReason, $quitLog = "")
    {
        $this->player = $player;
        $this->quitMessage = $quitMessage;
        $this->quitReason = $quitReason;
        $this->quitLog = $quitLog;
    }

    public function setQuitMessage($quitMessage)
    {
        $this->quitMessage = $quitMessage;
    }

    public function getQuitMessage()
    {
        return $this->quitMessage;
    }

    public function getQuitReason()
    {
        return $this->quitReason;
    }

    public function getQuitLog()
    {
        return $this->quitLog;
    }
}