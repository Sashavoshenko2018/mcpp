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

namespace mcpp\command;

use Exception;
use mcpp\command\defaults\BanCommand;
use mcpp\command\defaults\BanIpCommand;
use mcpp\command\defaults\BanListCommand;
use mcpp\command\defaults\DefaultGamemodeCommand;
use mcpp\command\defaults\DeopCommand;
use mcpp\command\defaults\DifficultyCommand;
use mcpp\command\defaults\EffectCommand;
use mcpp\command\defaults\GamemodeCommand;
use mcpp\command\defaults\GiveCommand;
use mcpp\command\defaults\HelpCommand;
use mcpp\command\defaults\KickCommand;
use mcpp\command\defaults\KillCommand;
use mcpp\command\defaults\ListCommand;
use mcpp\command\defaults\MakeServerCommand;
use mcpp\command\defaults\MeCommand;
use mcpp\command\defaults\OpCommand;
use mcpp\command\defaults\PardonCommand;
use mcpp\command\defaults\PardonIpCommand;
use mcpp\command\defaults\ParticleCommand;
use mcpp\command\defaults\PingCommand;
use mcpp\command\defaults\PluginsCommand;
use mcpp\command\defaults\ReloadCommand;
use mcpp\command\defaults\SaveCommand;
use mcpp\command\defaults\SaveOffCommand;
use mcpp\command\defaults\SaveOnCommand;
use mcpp\command\defaults\SayCommand;
use mcpp\command\defaults\SeedCommand;
use mcpp\command\defaults\SetWorldSpawnCommand;
use mcpp\command\defaults\SpawnpointCommand;
use mcpp\command\defaults\StatusCommand;
use mcpp\command\defaults\StopCommand;
use mcpp\command\defaults\TeleportCommand;
use mcpp\command\defaults\TellCommand;
use mcpp\command\defaults\TimeCommand;
use mcpp\command\defaults\TimingsCommand;
use mcpp\command\defaults\TransferCommand;
use mcpp\command\defaults\VanillaCommand;
use mcpp\command\defaults\VersionCommand;
use mcpp\command\defaults\WhitelistCommand;
use mcpp\Server;
use mcpp\utils\MainLogger;

class SimpleCommandMap implements CommandMap
{
    /**
     * @var Command[]
     */
    protected $knownCommands = [];
    /** @var Server */
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
        $this->setDefaultCommands();
    }

    private function setDefaultCommands()
    {
        $this->register("mcpp", new VersionCommand("version"));
        $this->register("mcpp", new PluginsCommand("plugins"));
        $this->register("mcpp", new SeedCommand("seed"));
        $this->register("mcpp", new HelpCommand("help"));
        $this->register("mcpp", new StopCommand("stop"));
        $this->register("mcpp", new TellCommand("tell"));
        $this->register("mcpp", new DefaultGamemodeCommand("defaultgamemode"));
        $this->register("mcpp", new BanCommand("ban"));
        $this->register("mcpp", new BanIpCommand("ban-ip"));
        $this->register("mcpp", new BanListCommand("banlist"));
        $this->register("mcpp", new PardonCommand("pardon"));
        $this->register("mcpp", new PardonIpCommand("pardon-ip"));
        $this->register("mcpp", new SayCommand("say"));
        $this->register("mcpp", new MeCommand("me"));
        $this->register("mcpp", new ListCommand("list"));
        $this->register("mcpp", new DifficultyCommand("difficulty"));
        $this->register("mcpp", new KickCommand("kick"));
        $this->register("mcpp", new OpCommand("op"));
        $this->register("mcpp", new DeopCommand("deop"));
        $this->register("mcpp", new WhitelistCommand("whitelist"));
        $this->register("mcpp", new SaveOnCommand("save-on"));
        $this->register("mcpp", new SaveOffCommand("save-off"));
        $this->register("mcpp", new SaveCommand("save-all"));
        $this->register("mcpp", new GiveCommand("give"));
        $this->register("mcpp", new EffectCommand("effect"));
        $this->register("mcpp", new ParticleCommand("particle"));
        $this->register("mcpp", new GamemodeCommand("gamemode"));
        $this->register("mcpp", new KillCommand("kill"));
        $this->register("mcpp", new SpawnpointCommand("spawnpoint"));
        $this->register("mcpp", new SetWorldSpawnCommand("setworldspawn"));
        $this->register("mcpp", new TeleportCommand("tp"));
        $this->register("mcpp", new TimeCommand("time"));
        $this->register("mcpp", new TimingsCommand("timings"));
        $this->register("mcpp", new ReloadCommand("reload"));
        $this->register("mcpp", new MakeServerCommand("makeserver"));

        $this->register("mcpp", new TransferCommand("transfer"));
        $this->register("mcpp", new PingCommand("ping"));

        if($this->server->getProperty("debug.commands", false) === true){
            $this->register("mcpp", new StatusCommand("status"));
        }
    }

    public function registerAll($fallbackPrefix, array $commands)
    {
        foreach($commands as $command){
            $this->register($fallbackPrefix, $command);
        }
    }

    public function register($fallbackPrefix, Command $command, $label = null)
    {
        if($label === null){
            $label = $command->getName();
        }
        $label = strtolower(trim($label));
        $fallbackPrefix = strtolower(trim($fallbackPrefix));

        $registered = $this->registerAlias($command, false, $fallbackPrefix, $label);

        $aliases = $command->getAliases();
        foreach($aliases as $index => $alias){
            if(!$this->registerAlias($command, true, $fallbackPrefix, $alias)){
                unset($aliases[$index]);
            }
        }
        $command->setAliases($aliases);

        if(!$registered){
            $command->setLabel($fallbackPrefix . ":" . $label);
        }

        $command->register($this);

        return $registered;
    }

    public function registerAlias(Command $command, $isAlias, $fallbackPrefix, $label)
    {
        $this->knownCommands[$fallbackPrefix . ":" . $label] = $command;
        if(($command instanceof VanillaCommand or $isAlias) and isset($this->knownCommands[$label])){
            return false;
        }

        if(isset($this->knownCommands[$label]) and $this->knownCommands[$label]->getLabel() !== null and $this->knownCommands[$label]->getLabel() === $label){
            return false;
        }

        if(!$isAlias){
            $command->setLabel($label);
        }

        $this->knownCommands[$label] = $command;

        return true;
    }

    private function parseArgs($commandLine)
    {
        $lines = (explode(' ', $commandLine));
        $newArgs = [];
        $i = 0;
        $state = 0;
        foreach($lines as $arg){
            if($arg == ''){
                continue;
            }
            $needNewArg = false;

            if($state == 0){
                if($arg{0} == '"'){
                    $state = 1;
                    $arg = substr($arg, 1);
                }elseif($arg{0} == '\''){
                    $state = 2;
                    $arg = substr($arg, 1);
                }else{
                    $needNewArg = true;
                }
            }

            if($arg == ''){
                continue;
            }

            if($state == 1){
                if($arg{strlen($arg) - 1} == '"'){
                    $state = 0;
                    $arg = substr($arg, 0, -1);
                    $needNewArg = true;
                }
            }
            if($state == 2){
                if($arg{strlen($arg) - 1} == '\''){
                    $needNewArg = true;
                    $state = 0;
                    $arg = substr($arg, 0, -1);
                }
            }

            if(!isset($newArgs[$i])){
                $newArgs[$i] = $arg;
            }else{
                $newArgs[$i] .= ' ' . $arg;
            }
            if($needNewArg){
                $i++;
            }
        }
        return $newArgs;
    }

    public function dispatch(CommandSender $sender, $commandLine)
    {
        $args = $this->parseArgs($commandLine);
        if(count($args) === 0){
            return false;
        }
        $sentCommandLabel = strtolower(array_shift($args));
        $target = $this->getCommand($sentCommandLabel);

        if($target === null){
            return false;
        }

        //$target->timings->startTiming();
        try{
            $target->execute($sender, $sentCommandLabel, $args);
        }catch(Exception $e){
            $this->server->getLogger()->critical("Unhandled exception executing command '" . $commandLine . "' in " . $target . ": " . $e->getMessage());
            $logger = $sender->getServer()->getLogger();
            if($logger instanceof MainLogger){
                $logger->logException($e);
            }
        }
        //$target->timings->stopTiming();

        return true;
    }

    public function clearCommands()
    {
        foreach($this->knownCommands as $command){
            $command->unregister($this);
        }
        $this->knownCommands = [];
        $this->setDefaultCommands();
    }

    public function unregister(Command $command)
    {
        unset($this->knownCommands[strtolower($command->getName())]);
        foreach($command->getAliases() as $alias){
            unset($this->knownCommands[strtolower($alias)]);
        }
    }

    public function getCommand($name)
    {
        if(isset($this->knownCommands[$name])){
            return $this->knownCommands[$name];
        }

        return null;
    }

    /**
     * @return Command[]
     */
    public function getCommands()
    {
        return $this->knownCommands;
    }

    /**
     * @return void
     */
    public function registerServerAliases()
    {
        $values = $this->server->getCommandAliases();

        foreach($values as $alias => $commandStrings){
            if(strpos($alias, ":") !== false or strpos($alias, " ") !== false){
                $this->server->getLogger()->warning("Could not register alias " . $alias . " because it contains illegal characters");
                continue;
            }

            $targets = [];

            $bad = "";
            foreach($commandStrings as $commandString){
                $args = explode(" ", $commandString);
                $command = $this->getCommand($args[0]);

                if($command === null){
                    if(strlen($bad) > 0){
                        $bad .= ", ";
                    }
                    $bad .= $commandString;
                }else{
                    $targets[] = $commandString;
                }
            }

            if(strlen($bad) > 0){
                $this->server->getLogger()->warning("Could not register alias " . $alias . " because it contains commands that do not exist: " . $bad);
                continue;
            }

            //These registered commands have absolute priority
            if(count($targets) > 0){
                $this->knownCommands[strtolower($alias)] = new FormattedCommandAlias(strtolower($alias), $targets);
            }else{
                unset($this->knownCommands[strtolower($alias)]);
            }
        }
    }
}
