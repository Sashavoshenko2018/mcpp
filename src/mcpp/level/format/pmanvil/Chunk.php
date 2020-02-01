<?php

namespace mcpp\level\format\pmanvil;

class Chunk extends \mcpp\level\format\anvil\Chunk
{
    protected static $chunkClass = Chunk::class;
    protected static $chunkSectionClass = ChunkSection::class;
    protected static $providerClass = PMAnvil::class;
}
