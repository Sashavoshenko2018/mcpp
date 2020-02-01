<?php

namespace mcpp\entity\animal\walking;

use mcpp\entity\animal\WalkingAnimal;
use mcpp\entity\Creature;
use mcpp\event\entity\EntityDamageByEntityEvent;
use mcpp\item\Item;
use mcpp\Player;

class Mooshroom extends WalkingAnimal
{
    const NETWORK_ID = 16;
    public $width = 1.45;
    public $height = 1.12;

    public function getName()
    {
        return "Mooshroom";
    }

    public function initEntity()
    {
        parent::initEntity();

        $this->setMaxHealth(10);
    }

    public function targetOption(Creature $creature, float $distance)
    {
        if($creature instanceof Player){
            return $creature->spawned && $creature->isAlive() && !$creature->closed && $creature->getInventory()->getItemInHand()->getId() == Item::WHEAT && $distance <= 49;
        }
        return false;
    }

    public function getDrops()
    {
        $drops = [];
        if($this->lastDamageCause instanceof EntityDamageByEntityEvent){
            $drops[] = Item::get(Item::MUSHROOM_STEW, 0, 1);
        }
        return $drops;
    }
}