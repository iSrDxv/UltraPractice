<?php

namespace isrdxv\ultrapractice\session;

use isrdxv\ultrapractice\UltraPractice;

use pocketmine\player\Player;
use pocketmine\Server;

class Session
{
  private string $username;
  
  private array $data;
  
  private bool $inLobby = true;
  
  public function __construct(Player $player)
  {
    $this->username = $player->getName();
    //$this->scoreboard = new ScoreboardHandler();
  }
  
  public function getPlayer(): ?Player
  {
    return Server::getInstance()->getPlayerByPrefix($this->username);
  }
  
  public function inLobby(): bool
  {
    return $this->inLobby;
  }
  
  public function setInLobby(bool $value = false): void
  {
    $this->inLobby = $value;
  }
  
  public function setElo(string $mode, int $amount = 15): bool
  {
    if ($amount <= 5) {
      return false;
    }
    if ($this->data["elo"][$mode] >= PHP_INT_MAX) {
      return false;
    }
    $this->data["elo"][$mode] += $amount;
    return true;
  }
  
  public function getElo(string $mode): int
  {
    return $this->data["elo"][$mode] ?? 1000;
  }
  
  public function getKDR(): float
  {
    return ($this->data["murders"] === 0 && $this->data["deaths"] === 0) ? 0.00 : $this->data["murders"] / $this->data["deaths"];
  }
  
  public function addMurder(): void
  {
    ++$this->data["murders"];
  }
  
  public function addDied(): void
  {
    ++$this->data["deaths"];
  }
  
  public function getMurders(): int
  {
    return $this->data["murders"];
  }
  
  public function getDeaths(): int
  {
    return $this->data["deaths"];
  }
  
  public function load(): void
  {
    if (UltraPractice::getPlayerData()->exists($this->username)) {
      $this->data = UltraPractice::getPlayerData()->getNested($this->username);
      return;
    }
    $this->data = [
      "murders" => 0,
      "deaths" => 0,
      "elo" => [
        "thebridge" => 1000,
        "nodebuff" => 1000,
        "gapple" => 1000,
        "combo" => 1000,
        "sumo" => 1000,
        "soup" => 1000,
        "hcf_trapping" => 1000
      ],
      "settings" => [
        "sprint" => false,
        "cps" => true,
        "scoreboard" => true,
        "autoJoin" => false
      ]
    ];
    Server::getInstance()->broadcastMessage(implode("\n", UltraPractice::getInstance()->getConfig()->get("message-welcome")));
  }
  
  public function save(): void
  {
    UltraPractice::getPlayerData()->setNested($this->username, $this->data);
    UltraPractice::getPlayerData()->save();
  }
  
}
