<?php

namespace mcpp\entity\effects;

use mcpp\entity\Entity;
use mcpp\entity\InstantEffect;
use mcpp\event\entity\EntityRegainHealthEvent;

class HealingEffect extends InstantEffect
{
    public function canTick()
    {
        return true;
    }

    public function applyEffect(Entity $entity)
    {
        $level = $this->amplifier + 1;
        $health = $entity->getHealth();
        $maxHealth = $entity->getMaxHealth();
        if(($health + 4 * $level) <= $maxHealth){
            $ev = new EntityRegainHealthEvent($entity, 4 * $level, EntityRegainHealthEvent::CAUSE_MAGIC);
            $entity->heal($ev->getAmount(), $ev);
        }else{
            $ev = new EntityRegainHealthEvent($entity, $maxHealth - $health, EntityRegainHealthEvent::CAUSE_MAGIC);
            $entity->heal($ev->getAmount(), $ev);
        }
    }
}
