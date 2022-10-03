<?php

namespace isrdxv\ultrapractice\world;

use pocketmine\world\{
  World,
  ChunkLoader,
  ChunkListener
};

class DuelChunkLoader implements ChunkLoader, ChunkListener
{
  private World $world;
  
  private float|int $x;
  
  private float|int $z;
  
  private callable $callable;
  
  public function __construct(World $world, float|int $x, float|int $z, callable $callable)
  {
    $this->world = $world;
    $this->x = $x;
    $this->z = $z;
    $this->callable = $callable;
  }
  
}