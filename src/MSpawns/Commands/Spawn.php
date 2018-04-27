<?php

/*
 * MSpawns (v2.1) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: https://www.evolsoft.tk
 * Date: 07/01/2018 04:29 PM (UTC)
 * Copyright & License: (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

use MSpawns\MSpawns;

class Spawn extends PluginBase implements CommandExecutor {
	
	public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
        if($sender instanceof Player){
			if($sender->hasPermission("mspawns.spawn")){
				if($this->plugin->teleportToSpawn($sender)){
				    if($this->plugin->isSpawnMessageEnabled()){
				        $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->getFormattedSpawnMessage($sender)));
				    }
				}else{
				    $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->replaceVars($this->plugin->getMessage("no-spawn"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $sender->getLevel()->getName()))));
				}
			}else{
				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
			}
		}else{
			$sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c You can only perform this command as a player"));
		}
    	return true;
    }
}