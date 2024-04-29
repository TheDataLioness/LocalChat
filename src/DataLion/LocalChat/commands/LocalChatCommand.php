<?php
namespace DataLion\LocalChat\commands;

use DataLion\LocalChat\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\PluginsCommand;
use pocketmine\command\PluginCommand;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

class LocalChatCommand extends Command
{
    public function __construct()
    {
        parent::__construct(
            "localchat",
            "Base Command for localchat",
            "/localchat",
        );
        $this->setPermission("lc.command");
    }
    /**
     * @throws \JsonException
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $plugin = Main::getInstance();
        $fallback_message = "§2-- §aLocalChat Usage §2--\n§a"."/localchat setradius <radius>\n"."§a/localchat toggle";
        
        if (!($sender instanceof Player)) {
            $sender->sendMessage("§c» §7Please use the command in-game.");
            return false;
        }
        if ($sender->hasPermission("lc.command")) {
            if (!isset($args[0])) {
                $sender->sendMessage($fallback_message);
                return true;
            }
            if ($args[0] == "setradius") {
                if ($sender->hasPermission("lc.command.setradius")) {
                    if (!isset($args[1]) || !is_numeric($args[1])) {
                        $sender->sendMessage("§cPlease provide a valid radius.");
                        return false;
                    }
                    $newRadius = intval($args[1]);
                    // Getting Config
                    $config = $plugin->getConfig();
                    // Setting and Saving Config
                    $config->set("radius", $newRadius);
                    $config->save();

                    $sender->sendMessage("§aRadius has been set to: $newRadius");
                    return true;
                } else {
                    $sender->sendMessage("§cYou do not have permission to set the radius.");
                    return false;
                }
            }
            if ($args[0] == "toggle") {
                if ($sender->hasPermission("lc.command.toggle")) {
                    $config = $plugin->getConfig();
                    $enabled = $config->get("enabled");

                    // Setting and Saving Config
                    $config->set("enabled", !$enabled);
                    $config->save();

                    if ($enabled) {
                        $sender->sendMessage("§cLocalChat Disabled.");
                    } else {
                        $sender->sendMessage("§aLocalChat Enabled.");
                    }
                    return true;
                } else {
                    $sender->sendMessage("§cYou do not have permission to toggle local chat.");
                    return false;
                }
            } else {
                $sender->sendMessage($fallback_message);
                return false;
            }
        }
        return false;
    }
}
