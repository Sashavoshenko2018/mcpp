<?php
namespace mcpp\block;

class RedstoneTorchActive extends RedstoneTorch{
	
	protected $id = self::REDSTONE_TORCH_ACTIVE;
	
	public function __construct($meta = 0){
		$this->meta = $meta;
	}
	
	public function getName(){
		return "Glowing Redstone Torch";
	}
	
}