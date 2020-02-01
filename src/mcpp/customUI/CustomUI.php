<?php

namespace mcpp\customUI;

use mcpp\Player;

interface CustomUI {

	public function handle($response, $player);
	
	public function toJSON();
	
	/**
	 * To handle manual closing
	 * 
	 * @var Player $player
	 */
	public function close($player);
}
