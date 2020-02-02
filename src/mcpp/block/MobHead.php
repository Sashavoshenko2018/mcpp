<?php

namespace mcpp\block;

use mcpp\item\Item;
use mcpp\item\Tool;
use mcpp\math\AxisAlignedBB;
use mcpp\nbt\tag\ByteTag;
use mcpp\nbt\tag\Compound;
use mcpp\nbt\tag\IntTag;
use mcpp\nbt\tag\StringTag;
use mcpp\Player;
use mcpp\tile\Skull;
use mcpp\tile\Tile;

class MobHead extends Transparent
{
    const SKELETON = 0;
    const WITHER_SKELETON = 1;
    const ZOMBIE_HEAD = 2;
    const STEVE_HEAD = 3;
    const CREEPER_HEAD = 4;
    const DRAGON_HEAD = 5;
    protected $id = self::MOB_HEAD_BLOCK;

    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }

    public function getHardness()
    {
        return 1;
    }

    public function isSolid()
    {
        return false;
    }

    public function getBoundingBox()
    {
        return new AxisAlignedBB(
            $this->x - 0.75,
            $this->y - 0.5,
            $this->z - 0.75,
            $this->x + 0.75,
            $this->y + 0.5,
            $this->z + 0.75
        );
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null)
    {
        $down = $this->getSide(0);
        if($face !== 0 && $fy > 0.5 && $target->getId() !== self::MOB_HEAD_BLOCK && !$down instanceof MobHead){
            $this->getLevel()->setBlock($block, Block::get(Block::MOB_HEAD_BLOCK, 0), true, true);
            if($face === 1){
                $rot = new ByteTag("Rot", floor(($player->yaw * 16 / 360) + 0.5) & 0x0F);
            }else{
                $rot = new ByteTag("Rot", 0);
            }
            $nbt = new Compound("", [
                new StringTag("id", Tile::SKULL),
                new IntTag("x", $block->x),
                new IntTag("y", $block->y),
                new IntTag("z", $block->z),
                new ByteTag("SkullType", $item->getDamage()),
                $rot
            ]);
            if($item->hasCustomBlockData()){
                foreach($item->getCustomBlockData() as $key => $v){
                    $nbt->{$key} = $v;
                }
            }
            $chunk = $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4);
            $pot = Tile::createTile(Tile::SKULL, $chunk, $nbt);
            $this->getLevel()->setBlock($block, Block::get(Block::MOB_HEAD_BLOCK, $face), true, true);
            return true;
        }
        return false;
    }

    public function getResistance()
    {
        return 5;
    }

    public function getName()
    {
        static $names = [
            0 => "Skeleton Head",
            1 => "Wither Skeleton Head",
            2 => "Zombie Head",
            3 => "Steve Head",
            4 => "Creeper Head"
        ];
        return $names[$this->meta & 0x04];
    }

    public function getToolType()
    {
        return Tool::TYPE_PICKAXE;
    }

    public function onBreak(Item $item)
    {
        $this->getLevel()->setBlock($this, new Air(), true, true);
        return true;
    }

    public function getDrops(Item $item)
    {
        /** @var Skull $tile */
        if($this->getLevel() != null && (($tile = $this->getLevel()->getTile($this)) instanceof Skull)){
            return [[Item::MOB_HEAD, $tile->getSkullType(), 1]];
        }else
            return [[Item::MOB_HEAD, 0, 1]];
    }
}