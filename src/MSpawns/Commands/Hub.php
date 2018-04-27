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

class Hub extends PluginBase implements CommandExecutor {
	
	public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
		if($sender instanceof Player){
			if($sender->hasPermission("mspawns.hub")){
			    switch($this->plugin->teleportToHub($sender)){
			        case MSpawns::ERR_HUB_INVALID_WORLD:
			            $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->replaceVars($this->plugin->getMessage("invalid-world"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $this->plugin->getHubName()))));
			            break;
			        case MSpawns::ERR_NO_HUB:
			            $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->replaceVars($this->plugin->getMessage("no-hub"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $this->plugin->getHubName()))));
			            break;
			        case MSpawns::ERR_HUB_TRANSFER:
			            $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->replaceVars($this->plugin->getMessage("transfer-error"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $this->plugin->getHubName()))));
			            break;
			        default:
			        case MSpawns::SUCCESS:
			            if($this->plugin->isHubMessageEnabled()){
			                $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->getFormattedHubMessage($sender)));
			            }
			            break;
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