<?php

namespace mcpp\item;

use mcpp\block\Block;

class Redstone extends Item
{
    public function __construct($meta = 0, $count = 1)
    {
        parent::__construct(Item::REDSTONE, $meta, $count, "Redstone");
        $this->block = Block::get(Block::REDSTONE_WIRE);
    }
}
