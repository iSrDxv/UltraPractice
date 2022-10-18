<?php

declare(strict_types=1);

namespace isrdxv\ultrapractice\entity;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\{Skin, Human, Location};

class CombatBot extends Human {

	public const EASY = 0; //🤨
	public const MEDIUM = 1; //🙂
	public const HARD = 2; //🌚
	public const HACKER = 3; //💀
	private string $name;
	private string $target = "";

	public function __construct(Location $location, Skin $skin, ?CompoundTag $nbt = null) {
		$this->setImmobile();
		parent::__construct($location, $skin, $nbt);
	}

	public function init(int $mode = self::EASY): void {
		$this->setCanSaveWithChunk(false);
		$this->name = match ($mode) {
			self::MEDIUM => TextFormat::GOLD."Medium Bot",
			self::HARD => TextFormat::RED."Hard Bot",
			self::HACKER => TextFormat::DARK_RED."Hacker Bot",
			default => TextFormat::GREEN."Easy Bot"
		};
		$this->setNameTag($this->name);
	}

	public function hasTarget(): bool {
		return ($this->target !== "" ? true : false) ?? false;
	}

	public function setTarget(?Player $target): void {
		$this->target = $target?->getName() ?? "";
		if($target !== null) {
			$this->setImmobile(false);
			//$this->setSprinting();
			$this->scheduleUpdate();
		}
	}

	public function getName(): string {
		return $this->name;
	}

	public function entityBaseTick(int $tickDiff = 1): bool {
		$hasUpdate = parent::entityBaseTick($tickDiff);
		if(!$this->isAlive() || ($this->target !== "" && ($target = $this->getTargetByPlayer()) === null || !$target->isAlive())) {
			if(!$this->closed) {
				$this->flagForDespawn();
			}
			return false;
		}
		$this->setNameTagAlwaysVisible(true);
		$this->setNameTagVisible(true);
		$this->setNameTag($this->getTagInCombat());
		if($target !== null) {
			// TODO
		}
		return $hasUpdate;
	}

	public function getTargetByPlayer(): Player {
		return Server::getInstance()?->getPlayerExact($this->target);
	}

	public function getTagInCombat(): string {
		return $this->name." | ".round($this->getHealth()).TextFormat::RED." ❤️";
	}
}
