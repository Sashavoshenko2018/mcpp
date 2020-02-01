<?php

namespace mcpp\form\element;

use mcpp\Player;

abstract class FormElement
{
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
