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

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

use MSpawns\MSpawns;

class SetAlias extends PluginBase implements CommandExecutor {
	
	public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
		if($sender->hasPermission("mspawns.setalias")){
			if(isset($args[0]) && isset($args[1])){
				if($this->plugin->setAlias($args[0], $args[1])){
					$sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&a Alias &e" . $args[0] ."&a set to &e" . $args[1]));
				}else{
					$sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c Can't set alias. No spawn found in world " . $args[1]));
				}
			}else{
				$sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c Usage /setalias <name> <target>"));
			}
		}else{
			$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
		}
    	return true;
    }	
}