<?php

namespace mcpp\block;

use mcpp\item\Item;
use mcpp\item\Tool;
use mcpp\nbt\NBT;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\Enum;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;
use mcpp\Player;
use mcpp\tile\Tile;

class EnderChest extends Transparent
{
    protected $id = self::ENDER_CHEST;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getName()
    {
        return 'Ender Chest';
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function getHardness()
    {
        return 22.5;
    }

    public function getLightLevel()
    {
        return 7;
    }

    public function getDrops(Item $item)
    {
        return [
            [self::OBSIDIAN, 0, 8]
        ];
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $faces = [0 => 4, 1 => 2, 2 => 5, 3 => 3];
        $this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0];

        $nbt = new Compound("", [
            new Enum("Items", []),
            new StringTag("id", Tile::ENDER_CHEST),
            new IntTag("x", $this->x),
            new IntTag("y", $this->y),
            new IntTag("z", $this->z)
        ]);
        $nbt->Items->setTagType(NBT::TAG_Compound);

        if($item->hasCustomName()){
            $nbt->CustomName = new StringTag("CustomName", $item->getCustomName());
        }
        if($item->hasCustomBlockData()){
            foreach($item->getCustomBlockData() as $key => $v){
                $nbt->{$key} = $v;
            }
        }

        $level = $this->getLevel();
        $level->setBlock($block, $this, true, true);
        Tile::createTile("EnderChest", $level->getChunk($this->x >> 4, $this->z >> 4), $nbt);

        return true;
    }

    /** @todo open */
    /** @todo inventory */
    /** @todo bunch of other things */

}
