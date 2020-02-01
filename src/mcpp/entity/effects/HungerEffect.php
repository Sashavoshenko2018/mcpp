<?php

namespace mcpp\entity\effects;

use mcpp\entity\Effect;
use mcpp\entity\Entity;

//use mcpp\entity\Human;

class HungerEffect extends Effect
{
    public function canTick()
    {
        if($this->amplifier < 0){ // prevents hacking with amplifier -1
            return false;
        }
        $interval = 20;
        return ($this->duration % $interval) === 0;
    }

    public function applyEffect(Entity $entity)
    {
        // some old unworking code
        //		if ($entity instanceof Human) {
        //			$entity->exhaust(0.5 * $this->amplifier, PlayerExhaustEvent::CAUSE_POTION);
        //		}
    }
}
