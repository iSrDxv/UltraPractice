<?php

namespace isrdxv\ultrapractice\session;

use isrdxv\ultrapractice\UltraPractice;

use pocketmine\player\Player;

class Session
{
  private string $username;
  
  private array $data;
  
  public function __construct(Player $player)
  {
    $this->username = $player->getName();
    //$this->scoreboard = new ScoreboardHandler();
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
        "nodebuff" => 1000,
        "gapple" => 1000,
        "combo" => 1000,
        "sumo" => 1000,
        "soup" => 1000
      ],
      "settings" => [
        "sprint" => false,
        "cps" => true,
        "scoreboard" => true,
        "autoJoin" => false
      ]
    ];
  }
  
  public function save(): void
  {
    UltraPractice::getPlayerData()->setNested($this->username, $this->data);
    UltraPractice::getPlayerData()->save();
  }
  
}
