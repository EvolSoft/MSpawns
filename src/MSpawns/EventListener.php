<?php

/*
 * MSpawns (v1.5) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: http://www.evolsoft.tk
 * Date: 06/06/2015 01:27 PM (UTC)
 * Copyright & License: (C) 2014-2017 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\player\PlayerEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
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
    
    public function onPlayerRespawn(PlayerRespawnEvent $event){
    	$this->cfg = $this->plugin->getConfig()->getAll();
    	$player = $event->getPlayer();
    	//Check if the victim is a Player
    	if($player instanceof Player){
    		//Teleport Player on Death: 1 = Teleport to spawn 2 = Teleport to Hub
    		if($this->cfg["teleport-on-death"] === 1){
    			//Check if spawn exists
    			if($this->plugin->SpawnExists($player->getLevel())){
    				$pos = $this->plugin->getSpawn($player->getLevel());
    				$event->setRespawnPosition(new Position($pos["X"], $pos["Y"], $pos["Z"]), $pos["Yaw"], $pos["Pitch"]);
    			}
    		}elseif($this->cfg["teleport-on-death"] === 2){
    			//Check if hub exists
    			if($this->plugin->HubExists()){
    				$this->plugin->teleportToHub($player);
    			}
    		}
    	}
    }
    
    public function onPlayerJoin(PlayerJoinEvent $event){
    	$player = $event->getPlayer();
    	if($this->plugin->getForceHub_OnJoin() === true){
    		$this->plugin->teleportToHub_OnJoin($player);
    	}else{
    		if($this->plugin->getForceSpawn_OnJoin() === true){
    			$this->plugin->teleportToSpawn_OnJoin($player);
    		}
    	}
    }
	
}
    
