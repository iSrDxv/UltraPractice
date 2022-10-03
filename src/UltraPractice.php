<?php

namespace isrdxv\ultrapractice;

use isrdxv\ultrapractice\discord\Discord;
use isrdxv\ultrapractice\session\SessionManager;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\{
  Config,
  SingletonTrait
};

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
  }
  
  protected function onEnable(): void
  {
    $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    Discord::sendStatus(true);
  }
  
  protected function onDisable(): void
  {
    Discord::sendStatus(false);
  }
  
  public static function getSessionManager(): SessionManager
  {
    return SessionManager::getInstance();
  }
  
  public static function getPlayerData(): Config
  {
    return new Config($this->getDataFolder() . "playerData.json", Config::JSON, []);
  }
  
}