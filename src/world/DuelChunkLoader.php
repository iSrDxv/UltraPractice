<?php

namespace isrdxv\ultrapractice\world;

use pocketmine\world\{
  World,
  ChunkLoader,
  ChunkListener,
  format\Chunk
};
use pocketmine\math\Vector3;

class DuelChunkLoader implements ChunkLoader, ChunkListener
{
  private World $world;
  
  private int $x;
  
  private int $z;
  
  private $callable;
  
  public function __construct(World $world, int $x, int $z, callable $callable)
  {
    $this->world = $world;
    $this->x = $x;
    $this->z = $z;
    $this->callable = $callable;
  }
  
  public function onChunkLoaded(int $chunkX, int $chunkZ, Chunk $chunk): void
  {
    if (!$chunk->isPopulated()) {
      return;
    }
    $this->onComplete();
  }
  
  public function onChunkPopulated(int $chunkX, int $chunkZ, Chunk $chunk): void
  {
		$this->onComplete();
	}
	
	public function onComplete(): void
	{
	  $this->world->unregisterChunkLoader($this, $this->x, $this->z);
	  $this->world->unregisterChunkListener($this, $this->x, $this->z);
	  ($this->callable)();
	}
	
	public function onChunkChanged(int $chunkX, int $chunkZ, Chunk $chunk): void
	{}
	
  public function onBlockChanged(Vector3 $block): void
  {}
	
  public function onChunkUnloaded(int $chunkX, int $chunkZ, Chunk $chunk): void
  {}
  
}