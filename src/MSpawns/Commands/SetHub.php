<?php

/*
 * MSpawns v2.2 by EvolSoft
 * Developer: Flavius12
 * Website: https://www.evolsoft.tk
 * Copyright (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;

use MSpawns\MSpawns;

class SetHub extends PluginCommand implements CommandExecutor {
	
	public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
		if($sender instanceof Player){
			if($sender->hasPermission("mspawns.sethub")){
			    if($this->plugin->isHubExternal()){
			        $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&e Your hub is currently set on an external server. Disable that feature to set a local hub."));
			    }
			    $this->plugin->setHub($sender->getLevel(), $sender->getX(), $sender->getY(), $sender->getZ(), $sender->getYaw(), $sender->getPitch());
			    $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&a Hub set on world &e" . $sender->getLevel()->getName()));
			}else{
				$sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
			}
		}else{
			$sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c You can only perform this command as a player"));
		}
    	return true;
    }
}
