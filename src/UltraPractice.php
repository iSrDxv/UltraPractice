<?php

namespace isrdxv\ultrapractice;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class UltraPractice extends PluginBase 
{
  use SingletonTrait;
  
  protected function onLoad(): void
  {
    $this->saveDefaultConfig();
  }
  
}