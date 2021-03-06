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

namespace mcpp\command\defaults;

use mcpp\command\CommandSender;
use mcpp\command\ConsoleCommandSender;
use mcpp\Player;
use mcpp\utils\TextFormat;

class SayCommand extends VanillaCommand
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Broadcasts the given message as the sender",
            "/say <message...>"
        );
        $this->setPermission("mcpp.command.say");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }

        if(count($args) === 0){
            $sender->sendMessage(TextFormat::RED . "Usage: " . $this->usageMessage);

            return false;
        }

        $message = TextFormat::LIGHT_PURPLE . "[";
        if($sender instanceof ConsoleCommandSender){
            $message .= "Server";
        }elseif($sender instanceof Player){
            $message .= $sender->getDisplayName();
        }else{
            $message .= $sender->getName();
        }
        $message .= TextFormat::LIGHT_PURPLE . "] " . implode(" ", $args);
        $sender->getServer()->broadcastMessage($message);

        return true;
    }
}