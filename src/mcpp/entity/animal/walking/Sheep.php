<?php

namespace mcpp\entity\animal\walking;

use mcpp\entity\animal\WalkingAnimal;
use mcpp\entity\Colorable;
use mcpp\entity\Creature;
use mcpp\event\entity\EntityDamageByEntityEvent;
use mcpp\item\Item;
use mcpp\Player;

class Sheep extends WalkingAnimal implements Colorable
{
    const NETWORK_ID = 13;
    public $width = 1.45;
    public $height = 1.12;

    public function getName()
    {
        return "Sheep";
    }

    public function initEntity()
    {
        parent::initEntity();

        $this->setMaxHealth(8);
    }

    public function targetOption(Creature $creature, float $distance)
    {
        if($creature instanceof Player){
            return $creature->spawned && $creature->isAlive() && !$creature->closed && $creature->getInventory()->getItemInHand()->getId() == Item::SEEDS && $distance <= 49;
        }
        return false;
    }

    public function getDrops()
    {
        if($this->lastDamageCause instanceof EntityDamageByEntityEvent){
            return [Item::get(Item::WOOL, mt_rand(0, 15), 1)];
        }
        return [];
    }
}