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
use mcpp\plugin\Plugin;
use mcpp\utils\TextFormat;

class VersionCommand extends VanillaCommand
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "Gets the version of this server including any plugins in use",
            "/version",
            ["ver", "about"]
        );
        $this->setPermission("pocketmine.command.version");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }
        $version = $sender->getServer()->getConfigString("game-version", "");
        $output = "";
        if(!empty($version)){
            $output .= $version . ". ";
        }
        $output .= "This server is running " . $sender->getServer()->getName() . " " . $sender->getServer()->getPocketMineVersion();

        $sender->sendMessage($output);
        //		if(count($args) === 0){
        //			$output = "This server is running " . $sender->getServer()->getName() . " version " . $sender->getServer()->getPocketMineVersion() . " 「" . $sender->getServer()->getCodename() . "」 (Implementing API version " . $sender->getServer()->getApiVersion() . " for Minecraft: PE " . $sender->getServer()->getVersion() . " protocol version " . Info::CURRENT_PROTOCOL . ")";
        //			if(\mcpp\GIT_COMMIT !== str_repeat("00", 20)){
        //				$output .= " [git " . \mcpp\GIT_COMMIT . "]";
        //			}
        //			$sender->sendMessage($output);
        //		}else{
        //			$pluginName = implode(" ", $args);
        //			$exactPlugin = $sender->getServer()->getPluginManager()->getPlugin($pluginName);
        //
        //			if($exactPlugin instanceof Plugin){
        //				$this->describeToSender($exactPlugin, $sender);
        //
        //				return true;
        //			}
        //
        //			$found = false;
        //			$pluginName = strtolower($pluginName);
        //			foreach($sender->getServer()->getPluginManager()->getPlugins() as $plugin){
        //				if(stripos($plugin->getName(), $pluginName) !== false){
        //					$this->describeToSender($plugin, $sender);
        //					$found = true;
        //				}
        //			}
        //
        //			if(!$found){
        //				$sender->sendMessage("This server is not running any plugin by that name.\nUse /plugins to get a list of plugins.");
        //			}
        //		}

        return true;
    }

    private function describeToSender(Plugin $plugin, CommandSender $sender)
    {
        $desc = $plugin->getDescription();
        $sender->sendMessage(TextFormat::DARK_GREEN . $desc->getName() . TextFormat::WHITE . " version " . TextFormat::DARK_GREEN . $desc->getVersion());

        if($desc->getDescription() != null){
            $sender->sendMessage($desc->getDescription());
        }

        if($desc->getWebsite() != null){
            $sender->sendMessage("Website: " . $desc->getWebsite());
        }

        if(count($authors = $desc->getAuthors()) > 0){
            if(count($authors) === 1){
                $sender->sendMessage("Author: " . implode(", ", $authors));
            }else{
                $sender->sendMessage("Authors: " . implode(", ", $authors));
            }
        }
    }
}