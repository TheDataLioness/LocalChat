<?php


namespace DataLion\LocalChat\commands;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;

class LocalChatCommand extends PluginCommand
{
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        switch ($args[0]??""){
            case "setradius":

                // Checking if Argument 2 exists and is numeric
                if(!isset($args[1]) || !is_numeric($args[1])){
                    $sender->sendMessage("§cPlease provide a valid radius.");
                    break;
                }
                $newRadius = intval($args[1]);

                // Getting Config
                $config = $this->getPlugin()->getConfig();

                // Setting and Saving Config
                $config->set("radius", $newRadius);
                $config->save();

                $sender->sendMessage("§aRadius has been set to: $newRadius");

                break;

            case "toggle":

                // Getting and current Config value
                $config = $this->getPlugin()->getConfig();
                $enabled = $config->get("enabled");

                // Setting and Saving Config
                $config->set("radius", !$enabled);
                $config->save();

                if($enabled){
                    $sender->sendMessage("§cLocalChat Disabled.");
                }else{
                    $sender->sendMessage("§aLocalChat Enabled.");
                }
                break;
        }

        return parent::execute($sender, $commandLabel, $args);
    }
}