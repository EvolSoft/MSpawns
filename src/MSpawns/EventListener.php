<?php

/*
 * MSpawns (v1.4) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: http://www.evolsoft.tk
 * Date: 27/12/2014 01:25 PM (UTC)
 * Copyright & License: (C) 2014 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\permission\Permission;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class EventListener extends PluginBase implements Listener{
	
	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    /* Possible implementation later
     * public function onWorldChange(EntityLevelChangeEvent $event){
    	$entity = $event->getEntity();
    	//Check if Entity is a Player
    	if($entity instanceof Player){
    		//Check Force Spawn
    		if($this->plugin->getForceSpawn()){
    			$this->plugin->teleportToSpawn_2($entity, $event->getTarget());
    		}
    	}
    }*/
    
    public function onCommandPreprocess(PlayerCommandPreprocessEvent $event){
    	$this->cfg = $this->plugin->getConfig()->getAll();
    	//Check if alias is enabled
    	if($this->cfg["enable-aliases"] == true){
    		$aliases = new Config($this->plugin->getDataFolder() . "aliases.yml", Config::YAML, array());
    		$aliases = $aliases->getAll();
    		$player = $event->getPlayer();
    		$message = $event->getMessage();
    		if($message{0} == "/"){ //Command
    			$command = substr($message, 1);
    			$command = strtolower($command);
    			//Check if command exists
    			if(isset($aliases[$command])){
    				//Check if world is loaded
    				if(Server::getInstance()->loadLevel($aliases[$command]) != false){
    					$player->teleport(Server::getInstance()->getLevelByName($aliases[$command])->getSafeSpawn());
    					$this->plugin->teleportToSpawn_2($player, Server::getInstance()->getLevelByName($aliases[$command]));
    				}else{
    					//Check if world can be loaded
    					if(Server::getInstance()->loadLevel($aliases[$command])){
    						$player->teleport(Server::getInstance()->getLevelByName($aliases[$command])->getSafeSpawn());
    						$this->plugin->teleportToSpawn_2($player, Server::getInstance()->getLevelByName($aliases[$command]));
    					}
    				}
    				$event->setCancelled(true);
    			}
    		}
    	}
    }
    
    public function onPlayerJoin(PlayerJoinEvent $event){
    	$player = $event->getPlayer();
    	if($this->plugin->getForceHub_OnJoin()=="true"){
    		$this->plugin->teleportToHub_OnJoin($player);
    	}else{
    		if($this->plugin->getForceSpawn_OnJoin()=="true"){
    			$this->plugin->teleportToSpawn_OnJoin($player);
    		}
    	}
    }
	
}
    ?>
