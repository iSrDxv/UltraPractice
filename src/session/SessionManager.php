<?php

namespace isrdxv\ultrapractice\session;

use isrdxv\ultrapractice\session\Session;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class SessionManager
{
  use SingletonTrait;
  
  /** @var Session[] **/
  private array $sessions = [];
  
  public function create(Player $player): void
  {
    $this->sessions[$player->getName()] = new Session($player);
  }
  
  public function get(Player|string $player): ?Session
  {
    if ($player instanceof Player && $player->isOnline()) {
      return $this->sessions[$player->getName()] ?? null;
    }
    return $this->sessions[$player] ?? null;
  }
  
  public function delete(Player $player): void
  {
    if (($session = $this->sessions[$player->getName()]) !== null) {
      $session->save();
      //$session->__destruct();
    }
  }
  
}