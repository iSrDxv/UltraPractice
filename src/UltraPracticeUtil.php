<?php

namespace isrdxv\ultrapractice;

use isrdxv\ultrapractice\world\DuelChunkLoader;

use pocketmine\network\mcpe\protocol\MoveActorAbsolutePacket;
use pocketmine\world\World;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class UltraPracticeUtil
{
  
  public static function secondToTick(int $num): int
  {
    return $num * 20;
  }
  
  public static function minuteToTick(int $num): int
  {
      return $num * 1200;
  }
    
  public static function hourToTick(int $num): int
  {
    return $num * 72000;
  }
  
  public static function tickToSecond(int $num): int
  {
      return intval($num / 20);
  }
   
  public static function tickToMinute(int $num): int
  {
    return intval($num / 1200);
  }
  
  public static function tickToHour(int $num): int
  {
    return intval($num / 72000);
  }
  
  public static function titleFormat(string $title): string
  {
    return TextFormat::BOLD . TextFormat::GRAY . "» " . TextFormat::RESET . $title . TextFormat::BOLD . TextFormat::GRAY . " «";
  }

  private static function look(Entity $entity, Vector3 $pos, ?Vector3 $view): array
  {
    if (empty($view)) {
      return [null, null];
    }
    $horizontal = sqrt(($view->x - $pos->x) ** 2 + ($view->z - $pos->z) ** 2);
    $vertical = $view->y - ($pos->y + $entity->getEyeHeight());
    $pitch = -atan2($vertical, $horizontal) / M_PI * 180;
    $xDist = $view->x - $pos->x;
    $zDist = $view->z - $pos->z;
    $yaw = atan2($zDist, $xDist) / M_PI * 180 - 90;
    if ($yaw < 0) {
        $yaw += 360.0;
    }
    return [$yaw, $pitch];
  }
  
  public static function teleport(Entity $entity, Vector3 $pos, ?Vector3 $look = null): void
  {
    [$yaw, $pitch] = self::look($entity, $pos, $look);
    $entity->teleport($pos, $yaw, $pitch);
    Server::getInstance()->broadcastPackets($entity->getViewers(), [MoveActorAbsolutePacket::create($entity->getId(), $entity->getOffsetPosition($location = $entity->getLocation()), $location->pitch, $location->yaw, $location->yaw, (MoveActorAbsolutePacket::FLAG_TELEPORT | ($entity->onGround ? MoveActorAbsolutePacket::FLAG_GROUND : 0)))]);
  }
  
  public static function onChunkGenerated(World $world, int $x, int $z, callable $callable): void
  {
    if (!$world->isLoaded()) {
      return;
    }
    if ($world->isChunkPopulated($x, $z)) {
      ($callable)();
      return;
    }
    $chunkLoader = new DuelChunkLoader($world, $x, $z, $callable);
    $world->registerChunkLoader($chunkLoader, $x, $z, true);
    $world->registerChunkListener($chunkLoader, $x, $z);
    $world->orderChunkPopulation($x, $z, $chunkLoader);
  }
  
}
