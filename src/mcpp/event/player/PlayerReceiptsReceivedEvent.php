<?php

namespace mcpp\event\player;

use mcpp\event\Cancellable;
use mcpp\Player;

class PlayerReceiptsReceivedEvent extends PlayerEvent implements Cancellable
{
    public static $handlerList = null;
    /** @var string[] */
    protected $receipts = [];

    /**
     * @param Player $player
     * @param string[] $receipts
     */
    public function __construct(Player $player, $receipts)
    {
        if(!is_array($receipts)){
            throw new Exception("$receipts whould be is array type");
        }
        $this->player = $player;
        $this->receipts = $receipts;
    }

    public function getReceipts()
    {
        return $this->receipts;
    }
}
