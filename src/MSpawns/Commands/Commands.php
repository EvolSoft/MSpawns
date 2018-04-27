<?php

/*
 * MSpawns (v2.1) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: https://www.evolsoft.tk
 * Date: 07/01/2018 04:30 PM (UTC)
 * Copyright & License: (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

use MSpawns\MSpawns;

class Commands extends PluginBase implements CommandExecutor {
	
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
	   		            $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&6 MSpawns &cv" . $this->plugin->getDescription()->getVersion() . "&6 developed by &cEvolSoft"));
	   		            $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&6 Website &c" . $this->plugin->getDescription()->getWebsite()));
	   		            break;
	   		        }
	   		        $sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
	   		        break;
	   		    case "reload":
	   		        if($sender->hasPermission("mspawns.reload")){
	   		            $this->plugin->reloadConfig();
	   		            $this->plugin->cfg = $this->plugin->getConfig()->getAll();
	   		            $this->plugin->spawns->reload();
	   		            $this->plugin->aliases->reload();
	   		            $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&a Configuration Reloaded."));
	   		            break;
	   		        }
	   		        $sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
	   		        break;
	   		    default:
	   		        if($sender->hasPermission("mspawns")){
	   		            $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c Subcommand &b" . $args[0] . " &cnot found. Use &b/ms &cto see available commands"));
	   		            break;
	   		        }
	   		        $sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
	   		        break;
	   		}
	   		return true;
	   	}
	   	help:
	   	if($sender->hasPermission("mspawns")){
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&c>> &6Available Commands &c<<"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/sethub &c>> &6Set hub"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/delhub &c>> &6Delete hub"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/hub &c>> &6Teleport player to hub"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/setspawn &c>> &6Set world spawn"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/delspawn &c>> &6Delete world spawn"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/spawn &c>> &6Teleport player to world spawn"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/setalias &c>> &6Set alias"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/delalias &c>> &6Delete alias"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/ms info &c>> &6Show info about this plugin"));
	   	    $sender->sendMessage($this->plugin->translateColors("&", "&6/ms reload &c>> &6Reload the config"));
	   	    return true;
   	   }
	   $sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
	   return true;
    }
}