<?php

namespace mcpp\form;

use mcpp\Player;

interface Form
{
    public function handle($response, $player);

    public function toJSON();

    /**
     * To handle manual closing
     *
     * @var Player $player
     */
    public function close($player);
}
