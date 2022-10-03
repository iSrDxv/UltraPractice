<?php

namespace isrdxv\ultrapractice\duel;

use isrdxv\ultrapractice\arena\type\DuelArena;
use isrdxv\ultrapractice\kit\type\DefaultKit;

use pocketmine\player\Player;

interface Duel
{
  public const MAX_DURATION_SECONDS = 800;
  
  public function __construct(DefaultKit $kit, DuelArena $arena, bool $ranked);
  
  public function addSpectator(string|Player $player): void;
  
  public function deleteSpectator(string|Player $player): void;
  
  public function isInSpectator(string|Player $player): bool;
  
  //if he is the defined player
  public function isThePlayer(string|Player $player): bool;
  
  //if the duel has started
  public function hasStarted(): bool;
  
  //if it is classified or not
  public function isRanked(): bool;
  
  //arena name
  public function getArena(): string;
  
  //kit name
  public function getKit(): string;
  
  //duration of the duel
  public function getDuration(): string;
  
  //Adds or teleports the player to the dueling arena
  public function addToDuel(): void;
}
