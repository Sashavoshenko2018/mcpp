<?php

namespace mcpp\event\player;

use mcpp\Player;

class PlayerRespawnAfterEvent extends PlayerEvent
{
    public static $handlerList = null;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }
}
