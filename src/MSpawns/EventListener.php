<?php

/*
 * MSpawns v2.2 by EvolSoft
 * Developer: Flavius12
 * Website: https://www.evolsoft.tk
 * Copyright (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\level\Position;
use pocketmine\utils\TextFormat;

class EventListener implements Listener {
    
    /** @var MSpawns */
    private $plugin;
	
	public function __construct(MSpawns $plugin){
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
    
    /**
     * @param PlayerRespawnEvent $event
     */
    public function onPlayerRespawn(PlayerRespawnEvent $event){
    	$this->cfg = $this->plugin->getConfig()->getAll();
    	$player = $event->getPlayer();
    	//Check if the victim is a Player
    	if($player instanceof Player){
    		//Teleport Player on Death: 1 = Teleport to spawn 2 = Teleport to Hub
    		if($this->cfg["teleport-on-death"] == 1){
    			//Check if spawn exists
    			if($this->plugin->spawnExists($player->getLevel())){
    				$pos = $this->plugin->getSpawn($player->getLevel());
    				$event->setRespawnPosition(new Position($pos["X"], $pos["Y"], $pos["Z"]), $pos["Yaw"], $pos["Pitch"]);
    			}
    		}elseif($this->cfg["teleport-on-death"] == 2){
    			//Check if hub exists
    			if($this->plugin->hubExists()){
    				$this->plugin->teleportToHub($player);
    			}
    		}
    	}
    }
    
    /**
     * @param PlayerJoinEvent $event
     */
    public function onPlayerJoin(PlayerJoinEvent $event){
    	$player = $event->getPlayer();
    	if($this->plugin->isForceHubEnabled()){
    	    switch($this->plugin->teleportToHub($player)){
    	        case MSpawns::ERR_HUB_INVALID_WORLD:
    	            $player->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("invalid-world"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $player->getName(), "WORLD" => $this->plugin->getHubName()))));
    	            break;
    	        case MSpawns::ERR_NO_HUB:
    	            $player->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("no-hub"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $player->getName(), "WORLD" => $this->plugin->getHubName()))));
    	            break;
    	        case MSpawns::ERR_HUB_TRANSFER:
    	            $player->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("transfer-error"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $player->getName(), "WORLD" => $this->plugin->getHubName()))));
    	            break;
    	        default:
    	        case MSpawns::SUCCESS:
    	            if($this->plugin->cfg["show-messages-onjoin"] && $this->plugin->isHubMessageEnabled()){
    	                $player->sendMessage(TextFormat::colorize($this->plugin->getFormattedHubMessage($player)));
    	            }
    	            break;
    	    }
    	}else if($this->plugin->isForceSpawnEnabled()){
    		if($this->plugin->teleportToSpawn($player)){
    		    if($this->plugin->cfg["show-messages-onjoin"] && $this->plugin->isSpawnMessageEnabled()){
    		        $player->sendMessage(TextFormat::colorize($this->plugin->getFormattedSpawnMessage($player)));
    		    }
    		}else{
    		    $player->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("no-spawn"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $player->getName(), "WORLD" => $player->getLevel()))));
    		}
    	}
    }
}
