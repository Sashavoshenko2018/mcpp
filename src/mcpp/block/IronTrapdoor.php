<?php

namespace mcpp\block;

use mcpp\item\Tool;

class IronTrapdoor extends Trapdoor
{
    protected $id = self::IRON_TRAPDOOR;

    public function getName()
    {
        return "Iron Trapdoor";
    }

    public function getHardness()
    {
        return 5;
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }
}