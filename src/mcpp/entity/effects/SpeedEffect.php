<?php

namespace mcpp\entity\effects;

use mcpp\entity\Effect;
use mcpp\entity\Entity;
use mcpp\Player;

class SpeedEffect extends Effect
{
    public function add(Entity $entity, $modify = false)
    {
        parent::add($entity, $modify);
        if($entity instanceof Player){
            $newSpeedValue = $entity::DEFAULT_SPEED * (1 + ($this->amplifier + 1) * 0.2);
            $entity->updateSpeed($newSpeedValue);
        }
    }

    public function remove(Entity $entity)
    {
        parent::remove($entity);
        if($entity instanceof Player){
            $entity->updateSpeed($entity->isSprinting() ? $entity::DEFAULT_SPEED * 1.3 : $entity::DEFAULT_SPEED);
        }
    }
}
