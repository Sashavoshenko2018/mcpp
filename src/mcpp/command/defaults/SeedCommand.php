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
use mcpp\Player;

class SeedCommand extends VanillaCommand
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Shows the world seed",
            "/seed"
        );
        $this->setPermission("pocketmine.command.seed");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }

        if($sender instanceof Player){
            $seed = $sender->getLevel()->getSeed();
        }else{
            $seed = $sender->getServer()->getDefaultLevel()->getSeed();
        }
        $sender->sendMessage("Seed: " . $seed);

        return true;
    }
}