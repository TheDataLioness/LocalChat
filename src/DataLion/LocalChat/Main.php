<?php
declare(strict_types=1);

namespace DataLion\LocalChat;
use DataLion\LocalChat\commands\LocalChatCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;

class Main extends PluginBase{

    /** @var ?Main */
    public static ?Main $instance;

    /**
     * @return Main
     */
    public static function getInstance(): Main
    {
        return self::$instance;
    }
	public function onEnable() : void{

	    // Creating Static plugin instance variable to use plugin base outside the main class
        self::$instance = $this;

		// Register Commands
        $this->getServer()->getCommandMap()->register("localchat", new LocalChatCommand("localchat", $this));

        // Register EventListener
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);

        // Creating Config
        $default_values = [
          "enabled" => true,
          "radius" => 20,
        ];
        new Config($this->getDataFolder()."config.yml", Config::YAML, $default_values);

	}
	public function onDisable(): void
    {
        // Prevent memory leaks
        self::$instance = null;
    }
}
