<?php


namespace DataLion\LocalChat;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;

class EventListener implements Listener
{

    public function onChat(PlayerChatEvent $event){

        // Getting Config
        $config = Main::getInstance()->getConfig();

        // Return if LocalChat is disabled
        if(!$config->get("enabled")) return;

        $player = $event->getPlayer();
        $radius = $config->get("radius");

        /** @var Player[] $newRecipents */
        $newRecipients = [];

        // Loop trough all recipients and add player if in radius
        foreach ($event->getRecipients() as $recipient){
            if($recipient instanceof Player){
                if($player->distance($recipient) <= $radius) $newRecipients[] = $recipient;
            }else{
                $newRecipients[] = $recipient;
            }

        }

        // Setting new Recipients
        $event->setRecipients($newRecipients);
    }

}