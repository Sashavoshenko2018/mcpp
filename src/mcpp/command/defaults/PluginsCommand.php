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
use mcpp\utils\TextFormat;

class PluginsCommand extends VanillaCommand
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Gets a list of plugins running on the server",
            "/plugins",
            ["pl"]
        );
        $this->setPermission("mcpp.command.plugins");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }

        $sender->sendMessage("Plugins " . $this->getPluginList($sender));

        return true;
    }

    private function getPluginList(CommandSender $sender)
    {
        $list = "";
        foreach(($plugins = $sender->getServer()->getPluginManager()->getPlugins()) as $plugin){
            if(strlen($list) > 0){
                $list .= TextFormat::WHITE . ", ";
            }
            $list .= $plugin->isEnabled() ? TextFormat::GREEN : TextFormat::RED;
            $list .= $plugin->getDescription()->getFullName();
        }

        return "(" . count($plugins) . "): $list";
    }
}
