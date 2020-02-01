<?php

namespace mcpp\entity\monster\walking;

use mcpp\entity\Entity;
use mcpp\entity\monster\WalkingMonster;
use mcpp\event\entity\EntityDamageByEntityEvent;
use mcpp\event\entity\EntityDamageEvent;
use mcpp\item\Item;

class Enderman extends WalkingMonster
{
    const NETWORK_ID = 38;
    public $width = 0.72;
    public $height = 2.8;

    public function getSpeed()
    {
        return 1.21;
    }

    public function initEntity()
    {
        parent::initEntity();

        $this->setDamage([0, 4, 7, 10]);
    }

    public function getName()
    {
        return "Enderman";
    }

    public function attackEntity(Entity $player)
    {
        if($this->attackDelay > 10 && $this->distanceSquared($player) < 1){
            $this->attackDelay = 0;
            $ev = new EntityDamageByEntityEvent($this, $player, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $this->getDamage());
            $player->attack($ev->getFinalDamage(), $ev);
        }
    }

    public function getDrops()
    {
        if($this->lastDamageCause instanceof EntityDamageByEntityEvent){
            return [Item::get(Item::END_STONE, 0, 1)];
        }
        return [];
    }
}
