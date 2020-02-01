<?php

namespace mcpp\customUI\elements\customForm;

use mcpp\customUI\elements\UIElement;
use mcpp\Player;

class Label extends UIElement {
	
	/**
	 * 
	 * @param string $text
	 */
	public function __construct($text) {
		$this->text = $text;
	}
	
	/**
	 * 
	 * @return array
	 */
	final public function getDataToJson() {
		return [
			"type" => "label",
			"text" => $this->text
		];
	}

	/**
	 * @notice Value for Label always null
	 * 
	 * @param null $value
	 * @param Player $player
	 */
	final public function handle($value, $player) {
	}
	
}
