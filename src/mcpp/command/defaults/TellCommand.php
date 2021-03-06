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

/*IMPORTANT NOTE: this command is owerridden inside lbcore, please do not update code here*/

namespace mcpp\command\defaults;

use mcpp\command\CommandSender;
use mcpp\Player;
use mcpp\utils\TextFormat;

class TellCommand extends VanillaCommand
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Sends a private message to the given player",
            "/tell <player> <message>",
            ["w", "msg"]
        );
        $this->setPermission("mcpp.command.tell");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }

        if(count($args) < 2){
            $sender->sendMessage(TextFormat::RED . "Usage: " . $this->usageMessage);

            return false;
        }

        $name = strtolower(array_shift($args));

        $player = $sender->getServer()->getPlayer($name);

        if($player instanceof Player){
            $player->setLastMessageFrom($sender->getName());
            $sender->sendMessage("[me -> " . $player->getName() . "] " . implode(" ", $args));
            $player->sendMessage("[" . $sender->getName() . " -> me] " . implode(" ", $args));
        }else{
            $sender->sendMessage("There's no player by that name online.");
        }

        return true;
    }
}
