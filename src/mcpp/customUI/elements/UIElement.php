<?php

namespace mcpp\customUI\elements;

use mcpp\Player;

abstract class UIElement {
	
	protected $text = '';
	
	/**
	 * @return array
	 */
	abstract public function getDataToJson();
	
	/**
	 * @param Player $player
	 */
	abstract public function handle($value, $player);
	
}
