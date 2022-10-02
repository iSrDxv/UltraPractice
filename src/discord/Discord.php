<?php

namespace isrdxv\ultrapractice\discord;

use isrdxv\ultrapractice\UltraPractice;

use CortexPE\DiscordWebhookAPI\Webhook;
use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Embed;

class Discord
{
  
  public static function sendStatus(bool $value): void
  {
    $webhook = new Webhook(UltraPractice::getInstance()->getConfig()->get("webhook")["status"]);
    $message = new Message();
    $embed = new Embed();
    $message->setUsername(UltraPractice::getInstance()->getConfig()->get("name"));
    $message->setAvatarURL(UltraPractice::getInstance()->getConfig()->get("logo"));
    $embed->setTitle("Status");
    $embed->setDescription("is now " . ($value ? "online": "offline"));
    $embed->setColor(($value ? 0x00CC00 : 0xFF0000));
    $embed->setTimestamp(new \DateTime("NOW"));
    $message->addEmbed($embed);
    $webhook->send($message);
  }
  
}
