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

class Commands extends PluginCommand implements CommandExecutor {
    
    /** @var MSpawns */
    private $plugin;
	
	public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
	   	if(isset($args[0])){
	   		$args[0] = strtolower($args[0]);
	   		switch($args[0]){
	   		    case "help":
	   		        goto help;
	   		    case "info":
	   		        if($sender->hasPermission("mspawns.info")){
	   		            $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&6 MSpawns &cv" . $this->plugin->getDescription()->getVersion() . "&6 developed by &cEvolSoft"));
	   		            $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&6 Website &c" . $this->plugin->getDescription()->getWebsite()));
	   		            break;
	   		        }
	   		        $sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
	   		        break;
	   		    case "reload":
	   		        if($sender->hasPermission("mspawns.reload")){
	   		            $this->plugin->reload();
	   		            $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&a Configuration Reloaded."));
	   		            break;
	   		        }
	   		        $sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
	   		        break;
	   		    default:
	   		        if($sender->hasPermission("mspawns")){
	   		            $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c Subcommand &b" . $args[0] . " &cnot found. Use &b/ms &cto see available commands"));
	   		            break;
	   		        }
	   		        $sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
	   		        break;
	   		}
	   		return true;
	   	}
	   	help:
	   	if($sender->hasPermission("mspawns")){
	   	    $sender->sendMessage(TextFormat::colorize("&c>> &6Available Commands &c<<"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/sethub &c>> &6Set hub"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/delhub &c>> &6Delete hub"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/hub &c>> &6Teleport player to hub"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/setspawn &c>> &6Set world spawn"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/delspawn &c>> &6Delete world spawn"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/spawn &c>> &6Teleport player to world spawn"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/setalias &c>> &6Set alias"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/delalias &c>> &6Delete alias"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/ms info &c>> &6Show info about this plugin"));
	   	    $sender->sendMessage(TextFormat::colorize("&6/ms reload &c>> &6Reload the config"));
	   	    return true;
   	   }
   	   $sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
	   return true;
    }
}
