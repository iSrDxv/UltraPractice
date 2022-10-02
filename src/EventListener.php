<?php

namespace isrdxv\ultrapractice;

use pocketmine\event\Listener;
use pocketmine\event\player\{
  PlayerPreLoginEvent,
  PlayerLoginEvent,
  PlayerJoinEvent,
  PlayerQuitEvent
};

class EventListener implements Listener
{
  
  public function onLogin(PlayerLoginEvent $event): void
  {
    UltraPractice::getSessionManager()->create($event->getPlayer());
  }
  
  public function onJoin(PlayerJoinEvent $event): void
  {
    UltraPractice::getSessionManager()->get($event->getPlayer())->load();
  }
  
  public function onQuit(PlayerQuitEvent $event): void
  {
    UltraPractice::getSessionManager()->delete($event->getPlayer());
  }
  
}
