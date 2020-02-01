<?php

namespace mcpp\entity\animal\walking;

use mcpp\entity\animal\WalkingAnimal;
use mcpp\entity\Rideable;
use mcpp\item\Item;
use mcpp\Player;
use mcpp\event\entity\EntityDamageByEntityEvent;
use mcpp\entity\Creature;

class Pig extends WalkingAnimal implements Rideable{
	const NETWORK_ID = 12;

	public $width = 1.45;
	public $height = 1.12;

	public function getName(){
		return "Pig";
	}

	public function initEntity(){
		parent::initEntity();

		$this->setMaxHealth(10);
	}

	public function targetOption(Creature $creature, float $distance){
		if($creature instanceof Player){
			return $creature->spawned && $creature->isAlive() && !$creature->closed && $creature->getInventory()->getItemInHand()->getId() == Item::CARROT && $distance <= 49;
		}
		return false;
	}

	public function getDrops(){
		if($this->lastDamageCause instanceof EntityDamageByEntityEvent){
			return [Item::get(Item::RAW_PORKCHOP, 0, 1)];
		}
		return [];
	}

}