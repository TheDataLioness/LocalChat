<?php
namespace DataLion\LocalChat;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\player\Player;

class EventListener implements Listener
{
    public function onChat(PlayerChatEvent $event): void
    {
        // Getting Config
        $config = Main::getInstance()->getConfig();

        // Return if LocalChat is disabled
        if(!$config->get("enabled")) return;

        $player = $event->getPlayer();
        $radius = $config->get("radius");

        /** @var Player[] $newRecipents */
        $newRecipients = [];

        // Loop through all recipients and add player if in radius
        foreach ($event->getRecipients() as $recipient){

            if ($recipient instanceof Player) {
                $recipientPosition = $recipient->getPosition();
                if($player->getPosition()->distance($recipientPosition) <= $radius && $recipient->getWorld() === $player->getWorld()) $newRecipients[] = $recipient;
            }else{
                $newRecipients[] = $recipient;
            }
        }
        // Setting new Recipients
        $event->setRecipients($newRecipients);
    }

}
