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

        // Loop trough all players in current World and add player if in radius
        foreach ($player->getLevel()->getPlayers() as $levelPlayer){
            if($player->distance($levelPlayer) <= $radius) $newRecipients[] = $levelPlayer;
        }

        // Setting new Recipients
        $event->setRecipients($newRecipients);
    }

}