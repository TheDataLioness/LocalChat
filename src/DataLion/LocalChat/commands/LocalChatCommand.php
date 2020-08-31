<?php


namespace DataLion\LocalChat\commands;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;

class LocalChatCommand extends PluginCommand
{

    public function __construct(string $name, Plugin $owner)
    {
        $this->setPermission("lc.command");
        $this->setPermissionMessage("§cYou have no permission to use this command.");
        parent::__construct($name, $owner);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $option = strtolower($args[0]??"");
        switch ($option){
            case"setradius":

                // Checking Permission
                if(!$sender->hasPermission($this->getPermission().".".$option)){
                    $sender->sendMessage($this->getPermissionMessage());
                    break;
                }

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

                // Checking Permission
                if(!$sender->hasPermission($this->getPermission().".".$option)){
                    $sender->sendMessage($this->getPermissionMessage());
                    break;
                }
                // Getting and current Config value
                $config = $this->getPlugin()->getConfig();
                $enabled = $config->get("enabled");

                // Setting and Saving Config
                $config->set("enabled", !$enabled);
                $config->save();

                if($enabled){
                    $sender->sendMessage("§cLocalChat Disabled.");
                }else{
                    $sender->sendMessage("§aLocalChat Enabled.");
                }
                break;
            default:
                // Sending usage message
                $sender->sendMessage("§2-- §aLocalChat Usage §2--");
                $sender->sendMessage("§a/localchat setradius <radius>");
                $sender->sendMessage("§a/localchat toggle");
        }

        return parent::execute($sender, $commandLabel, $args);
    }
}