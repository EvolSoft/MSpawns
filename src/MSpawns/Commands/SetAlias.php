<?php

/*
 * MSpawns v2.2 by EvolSoft
 * Developer: Flavius12
 * Website: https://www.evolsoft.tk
 * Copyright (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;

use MSpawns\MSpawns;

class SetAlias extends PluginCommand implements CommandExecutor {
    
    /** @var MSpawns */
    private $plugin;
	
	public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
		if($sender->hasPermission("mspawns.setalias")){
			if(isset($args[0]) && isset($args[1])){
				if($this->plugin->setAlias($args[0], $args[1])){
					$sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&a Alias &e" . $args[0] ."&a set to &e" . $args[1]));
				}else{
					$sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c Can't set alias. No spawn found in world " . $args[1]));
				}
			}else{
				$sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c Usage /setalias <name> <target>"));
			}
		}else{
			$sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
		}
    	return true;
    }	
}
