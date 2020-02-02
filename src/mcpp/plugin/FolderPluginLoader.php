<?php

/*
___  ___
|  \/  |
| .  . | ___ _ __  _ __ 
| |\/| |/ __| '_ \| '_ \
| |  | | (__| |_) | |_) |
\_|  |_/\___| .__/| .__/
            | |   | |
            |_|   |_|

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

*/

namespace mcpp\plugin;

use Exception;
use InvalidStateException;

use mcpp\event\plugin\PluginDisableEvent;
use mcpp\event\plugin\PluginEnableEvent;
use mcpp\Server;
use mcpp\utils\PluginException;

use function file_exists;
use function file_get_contents;
use function is_dir;

class FolderPluginLoader implements PluginLoader
{
	/** @var Server */
    private $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

	/**
	 * @param string $file
	 *
	 * @return Plugin
	 */
	public function loadPlugin($file){
		if(is_dir($file) and file_exists($file . "/plugin.yml") and file_exists($file . "/src/")){
			if(($description = $this->getPluginDescription($file)) instanceof PluginDescription){
				$this->server->getLogger()->info("Loading folder plugin: " . $description->getFullName());
				$dataFolder = dirname($file) . DIRECTORY_SEPARATOR . $description->getName();
				if(file_exists($dataFolder) and !is_dir($dataFolder)){
					trigger_error("Projected datafolder '" . $dataFolder . "' for " . $description->getName() . " exists and is not a directory", E_USER_WARNING);
					return null;
				}
				$className = $description->getMain();
				$this->server->getLoader()->addPath($file . "/src");
				if(class_exists($className, true)){
					$plugin = new $className();
					$this->initPlugin($plugin, $description, $dataFolder, $file);
					return $plugin;
				}else{
					trigger_error("Couldn't load source plugin " . $description->getName() . ": main class not found", E_USER_WARNING);
					return null;
				}
			}
		}

		return null;
	}

	/**
	 * @param string $file
	 *
	 * @return PluginDescription
	 */
	public function getPluginDescription($file){
		if(is_dir($file) and file_exists($file . "/plugin.yml")){
			$yaml = @file_get_contents($file . "/plugin.yml");
			if($yaml != ""){
				return new PluginDescription($yaml);
			}
		}

		return null;
	}

	/**
	 * @return array|string
     */
	public function getPluginFilters(){
		return "/[^\\.]/";
	}

	/**
	 * @param PluginBase        $plugin
	 * @param PluginDescription $description
	 * @param string            $dataFolder
	 * @param string            $file
	 */
	private function initPlugin(PluginBase $plugin, PluginDescription $description, $dataFolder, $file){
		$plugin->init($this, $this->server, $description, $dataFolder, $file);
		$plugin->onLoad();
	}

	/**
	 * @param Plugin $plugin
	 */
	public function enablePlugin(Plugin $plugin){
		if($plugin instanceof PluginBase and !$plugin->isEnabled()){
			$this->server->getLogger()->info("Enabling " . $plugin->getDescription()->getFullName());

			$plugin->setEnabled(true);

			Server::getInstance()->getPluginManager()->callEvent(new PluginEnableEvent($plugin));
		}
	}

	/**
	 * @param Plugin $plugin
	 */
	public function disablePlugin(Plugin $plugin){
		if($plugin instanceof PluginBase and $plugin->isEnabled()){
			$this->server->getLogger()->info("Disabling " . $plugin->getDescription()->getFullName());

			Server::getInstance()->getPluginManager()->callEvent(new PluginDisableEvent($plugin));

			$plugin->setEnabled(false);
		}
	}
}
