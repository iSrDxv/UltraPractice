<?php

namespace isrdxv\ultrapractice;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

use JackMD\ConfigUpdater\ConfigUpdater;
use JackMD\UpdateNotifier\UpdateNotifier;

class UltraPractice extends PluginBase 
{
  use SingletonTrait;
  
  public const CONFIG_VERSION = 0;
  
  protected function onLoad(): void
  {
    UpdateNotifier::checkUpdate($this->getDescription()->getName(), $this->getDescription()->getVersion());
    if (ConfigUpdater::checkUpdate($this, $this->getConfig(), "version", self::CONFIG_VERSION)) {
      $this->reloadConfig();
    }
    Discord::sendStatus(true);
  }
  
  protected function onDisable(): void
  {
    Discord::sendStatus(false);
  }
  
}
