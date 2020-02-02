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
use mcpp\event\entity\EntityDamageEvent;
use mcpp\Player;
use mcpp\utils\TextFormat;

class KillCommand extends VanillaCommand
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Commits suicide, only usable as a player",
            "/kill"
        );
        $this->setPermission("mcpp.command.kill");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }

        if($sender instanceof Player){
            $sender->getServer()->getPluginManager()->callEvent($ev = new EntityDamageEvent($sender, EntityDamageEvent::CAUSE_SUICIDE, 1000));

            if($ev->isCancelled()){
                return true;
            }

            $sender->setLastDamageCause($ev);
            $sender->setHealth(0);
        }else{
            $sender->sendMessage(TextFormat::RED . "You can only perform this command as a player");
        }

        return true;
    }
}
