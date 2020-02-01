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

use mcpp\block\Block;
use mcpp\command\CommandSender;
use mcpp\item\Item;
use mcpp\level\particle\BubbleParticle;
use mcpp\level\particle\CriticalParticle;
use mcpp\level\particle\DustParticle;
use mcpp\level\particle\EnchantParticle;
use mcpp\level\particle\ExplodeParticle;
use mcpp\level\particle\FlameParticle;
use mcpp\level\particle\HeartParticle;
use mcpp\level\particle\InkParticle;
use mcpp\level\particle\ItemBreakParticle;
use mcpp\level\particle\LavaDripParticle;
use mcpp\level\particle\LavaParticle;
use mcpp\level\particle\Particle;
use mcpp\level\particle\PortalParticle;
use mcpp\level\particle\RedstoneParticle;
use mcpp\level\particle\SmokeParticle;
use mcpp\level\particle\SplashParticle;
use mcpp\level\particle\SporeParticle;
use mcpp\level\particle\TerrainParticle;
use mcpp\level\particle\WaterDripParticle;
use mcpp\level\particle\WaterParticle;
use mcpp\math\Vector3;
use mcpp\Player;
use mcpp\utils\Random;

class ParticleCommand extends VanillaCommand
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            "%pocketmine.command.particle.description",
            "%pocketmine.command.particle.usage"
        );
        $this->setPermission("pocketmine.command.particle");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }

        if(count($args) < 7){
            return true;
        }

        if($sender instanceof Player){
            $level = $sender->getLevel();
        }else{
            $level = $sender->getServer()->getDefaultLevel();
        }

        $name = strtolower($args[0]);

        $pos = new Vector3((float)$args[1], (float)$args[2], (float)$args[3]);

        $xd = (float)$args[4];
        $yd = (float)$args[5];
        $zd = (float)$args[6];

        $count = isset($args[7]) ? max(1, (int)$args[7]) : 1;

        $data = isset($args[8]) ? (int)$args[8] : null;

        $particle = $this->getParticle($name, $pos, $xd, $yd, $zd, $data);

        if($particle === null){
            return true;
        }

        $random = new Random((int)(microtime(true) * 1000) + mt_rand());

        for($i = 0; $i < $count; ++$i){
            $particle->setComponents(
                $pos->x + $random->nextSignedFloat() * $xd,
                $pos->y + $random->nextSignedFloat() * $yd,
                $pos->z + $random->nextSignedFloat() * $zd
            );
            $level->addParticle($particle);
        }

        return true;
    }

    /**
     * @param $name
     *
     * @return Particle
     */
    private function getParticle($name, Vector3 $pos, $xd, $yd, $zd, $data)
    {
        switch($name){
            case "explode":
                return new ExplodeParticle($pos);
            case "bubble":
                return new BubbleParticle($pos);
            case "splash":
                return new SplashParticle($pos);
            case "wake":
            case "water":
                return new WaterParticle($pos);
            case "crit":
                return new CriticalParticle($pos);
            case "smoke":
                return new SmokeParticle($pos, $data !== null ? $data : 0);
            case "spell":
                return new EnchantParticle($pos);
            case "dripwater":
                return new WaterDripParticle($pos);
            case "driplava":
                return new LavaDripParticle($pos);
            case "townaura":
            case "spore":
                return new SporeParticle($pos);
            case "portal":
                return new PortalParticle($pos);
            case "flame":
                return new FlameParticle($pos);
            case "lava":
                return new LavaParticle($pos);
            case "reddust":
                return new RedstoneParticle($pos, $data !== null ? $data : 1);
            case "snowballpoof":
                return new ItemBreakParticle($pos, Item::get(Item::SNOWBALL));
            case "itembreak":
                if($data !== null and $data !== 0){
                    return new ItemBreakParticle($pos, $data);
                }
                break;
            case "terrain":
                if($data !== null and $data !== 0){
                    return new TerrainParticle($pos, $data);
                }
                break;
            case "heart":
                return new HeartParticle($pos, $data !== null ? $data : 0);
            case "ink":
                return new InkParticle($pos, $data !== null ? $data : 0);
        }

        if(substr($name, 0, 10) === "iconcrack_"){
            $d = explode("_", $name);
            if(count($d) === 3){
                return new ItemBreakParticle($pos, Item::get((int)$d[1], (int)$d[2]));
            }
        }elseif(substr($name, 0, 11) === "blockcrack_"){
            $d = explode("_", $name);
            if(count($d) === 2){
                return new TerrainParticle($pos, Block::get($d[1] & 0xff, $d[1] >> 12));
            }
        }elseif(substr($name, 0, 10) === "blockdust_"){
            $d = explode("_", $name);
            if(count($d) >= 4){
                return new DustParticle($pos, $d[1] & 0xff, $d[2] & 0xff, $d[3] & 0xff, isset($d[4]) ? $d[4] & 0xff : 255);
            }
        }

        return null;
    }
}