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

class Hub extends PluginCommand implements CommandExecutor {
    
    /** @var MSpawns */
    private $plugin;
	
	public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
		if($sender instanceof Player){
			if($sender->hasPermission("mspawns.hub")){
			    switch($this->plugin->teleportToHub($sender)){
			        case MSpawns::ERR_HUB_INVALID_WORLD:
			            $sender->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("invalid-world"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $this->plugin->getHubName()))));
			            break;
			        case MSpawns::ERR_NO_HUB:
			            $sender->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("no-hub"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $this->plugin->getHubName()))));
			            break;
			        case MSpawns::ERR_HUB_TRANSFER:
			            $sender->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("transfer-error"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $this->plugin->getHubName()))));
			            break;
			        default:
			        case MSpawns::SUCCESS:
			            if($this->plugin->isHubMessageEnabled()){
			                $sender->sendMessage(TextFormat::colorize($this->plugin->getFormattedHubMessage($sender)));
			            }
			            break;
			    }
			}else{
				$sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
			}
		}else{
			$sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c You can only perform this command as a player"));
		}
    	return true;
    }
}
