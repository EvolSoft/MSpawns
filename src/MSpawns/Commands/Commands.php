<?php

/*
 * MSpawns (v1.5) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: http://www.evolsoft.tk
 * Date: 27/12/2014 01:25 PM (UTC)
 * Copyright & License: (C) 2014-2017 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use MSpawns\Main;

class Commands extends PluginBase implements CommandExecutor{
	
	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
    	switch(strtolower($cmd->getName())){
    			   case "mspawns":
    			   	if(isset($args[0])) {
    			   		$args[0] = strtolower($args[0]);
    			   		if($args[0] === "reload"){
    			   			if ($sender->hasPermission("mspawns.reload")) {
    			   				$this->plugin->reloadConfig();
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aConfiguration Reloaded."));
    			   				return true;
    			   			}
    			   			else {
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   				return true;
    			   			}
    			   		}
    			   		elseif($args[0] === "info"){
    			   			if ($sender->hasPermission("mspawns.info")) {
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&6MSpawns &cv" . Main::VERSION . " &6developed by&c " . Main::PRODUCER));
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&6Website &c" . Main::MAIN_WEBSITE));
    			   				return true;
    			   			}
    			   			else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   				return true;
    			   			}
    			   		}elseif($args[0] === "setalias"){
    			   			if($sender->hasPermission("mspawns.setalias")){
    			   				if(isset($args[1]) && isset($args[1])){
    			   					if($this->plugin->setAlias($args[1], $args[2])){
    			   						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aAlias Set"));
    			   					}else{
    			   						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cCan't set alias. Spawn not found in world " . $args[2]));
    			   					}
    			   				}else{
    			   					$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cUsage /ms setalias <name> <target>"));
    			   				}
    			   				return true;
    			   			}else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   				return true;
    			   			}
    			   		}elseif($args[0] === "sethub"){
    			   			if($sender instanceof Player){
    			   				if($sender->hasPermission("mspawns.sethub")){
    			   					$this->plugin->setHub($sender);
    			   					return true;
    			   				}
    			   				else{
    			   					$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   					return true;
    			   				}
    			   			}else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    			   				return true;
    			   			}
    			   		}elseif($args[0] === "hub"){
    			   			if($sender instanceof Player){
    			   				if($sender->hasPermission("mspawns.hub")){
    			   					$this->plugin->teleportToHub($sender);
    			   					return true;
    			   				}
    			   				else{
    			   					$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   					return true;
    			   				}
    			   			}else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    			   				return true;
    			   			}	
    			   		}elseif($args[0] === "setspawn"){
    			   			if($sender instanceof Player){
    			   				if($sender->hasPermission("mspawns.setspawn")){
    			   					$this->plugin->setSpawn($sender);
    			   					return true;
    			   				}
    			   				else{
    			   					$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   					return true;
    			   				}
    			   			}else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    			   				return true;
    			   			}
    			   		}elseif($args[0] === "spawn"){
    			   			if($sender instanceof Player){
    			   				if($sender->hasPermission("mspawns.spawn")){
    			   					$this->plugin->teleportToSpawn($sender);
    			   					return true;
    			   				}
    			   				else{
    			   					$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   					return true;
    			   				}
    			   			}else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    			   				return true;
    			   			}
    			   		}else{
    			   			if($sender->hasPermission("mspawns")){
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cSubcommand &b" . $args[0] . " &cnot found. Use &b/ms &cto see available commands"));
    			   				break;
    			   			}
    			   			else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   				break;
    			   			}
    			   			return true;
    			   		}
    			   	}
    			   	else{
    			   		if($sender->hasPermission("mspawns")){
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&c>> &6Available Commands &c<<"));
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&6/sethub &cor &6/ms sethub &c>> &6Set hub"));
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&6/hub &cor &6/ms hub &c>> &6Teleport player to hub"));
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&6/setspawn &cor &6/ms setspawn &c>> &6Set world spawn"));
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&6/spawn &6or &6/ms spawn &c>> &6Teleport player to world spawn"));
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&6/setalias &cor &6/ms setalias &c>> &6Set alias"));
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&6/ms info &c>> &6Show info about this plugin"));
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&6/ms reload &c>> &6Reload the config"));
    			   				break;
    			   			}
    			   			else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   				break;
    			   			}
    			   			return true;
    			   	}
    		}
    	return true;
    }
	
}
   
