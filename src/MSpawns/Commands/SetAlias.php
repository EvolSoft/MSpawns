<?php

/*
 * MSpawns (v1.5) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: http://www.evolsoft.tk
 * Date: 27/12/2014 01:26 PM (UTC)
 * Copyright & License: (C) 2014-2017 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\permission\Permission;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use MSpawns\Main;

class SetAlias extends PluginBase implements CommandExecutor{
	
	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
    	switch(strtolower($cmd->getName())){
    			case "setalias":
    				if($sender->hasPermission("mspawns.setalias")){
    					if(isset($args[0]) && isset($args[1])){
    						if($this->plugin->setAlias($args[0], $args[1])){
    							$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aAlias Set"));
    						}else{
    							$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cCan't set alias. Spawn not found in world " . $args[1]));
    						}
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cUsage /setalias <name> <target>"));
    					}
    					return true;
    				}else{
    					$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    					return true;
    				}
				break;  
    		}
    	return true;
    }
	
}
    
