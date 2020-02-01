<?php

namespace mcpp\level\format\pmanvil;

use mcpp\level\format\anvil\Anvil;

class PMAnvil extends Anvil {

	const REGION_FILE_EXTENSION = "mcapm";

	protected $chunkClass = Chunk::class;
	protected $regionLoaderClass = RegionLoader::class;
	protected static $chunkSectionClass = ChunkSection::class;

	public static function getProviderName() {
		return "pmanvil";
	}
	
	public function requestChunkTask($x, $z) {
		$data = parent::requestChunkTask($x, $z);
		$data['isSorted'] = true;	
		return $data;
	}

}
