<?php

/*
 * MSpawns (v1.5) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: http://www.evolsoft.tk
 * Date: 06/06/2015 01:26 PM (UTC)
 * Copyright & License: (C) 2014-2017 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandExecutor;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{
	
	//About Plugin Const
	const PRODUCER = "EvolSoft";
	const VERSION = "1.5";
	const MAIN_WEBSITE = "http://www.evolsoft.tk";
	//Other Const
	//Prefix
	const PREFIX = "&7[&cMSpawns&7] ";
	
    public $cfg;
    
    public $aliases;
	
	public $spawns;
	 

	public function translateColors($symbol, $message){
		$message = str_replace($symbol."0", TextFormat::BLACK, $message);
		$message = str_replace($symbol."1", TextFormat::DARK_BLUE, $message);
		$message = str_replace($symbol."2", TextFormat::DARK_GREEN, $message);
		$message = str_replace($symbol."3", TextFormat::DARK_AQUA, $message);
		$message = str_replace($symbol."4", TextFormat::DARK_RED, $message);
		$message = str_replace($symbol."5", TextFormat::DARK_PURPLE, $message);
		$message = str_replace($symbol."6", TextFormat::GOLD, $message);
		$message = str_replace($symbol."7", TextFormat::GRAY, $message);
		$message = str_replace($symbol."8", TextFormat::DARK_GRAY, $message);
		$message = str_replace($symbol."9", TextFormat::BLUE, $message);
		$message = str_replace($symbol."a", TextFormat::GREEN, $message);
		$message = str_replace($symbol."b", TextFormat::AQUA, $message);
		$message = str_replace($symbol."c", TextFormat::RED, $message);
		$message = str_replace($symbol."d", TextFormat::LIGHT_PURPLE, $message);
		$message = str_replace($symbol."e", TextFormat::YELLOW, $message);
		$message = str_replace($symbol."f", TextFormat::WHITE, $message);
		
		$message = str_replace($symbol."k", TextFormat::OBFUSCATED, $message);
		$message = str_replace($symbol."l", TextFormat::BOLD, $message);
		$message = str_replace($symbol."m", TextFormat::STRIKETHROUGH, $message);
		$message = str_replace($symbol."n", TextFormat::UNDERLINE, $message);
		$message = str_replace($symbol."o", TextFormat::ITALIC, $message);
		$message = str_replace($symbol."r", TextFormat::RESET, $message);
		
		return $message;
	}
	
    public function onEnable(){
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->cfg = $this->getConfig()->getAll();
        $this->saveResource("aliases.yml");
        $this->saveResource("spawns.yml");
        $this->aliases = new Config($this->getDataFolder() . "aliases.yml", Config::YAML, array());
        $this->spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
        $this->registerCommands();
        if($this->cfg["enable-aliases"] === true){
        	$this->reloadAliases();
        }
	    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
    
    private function registerCommands(){
        $this->getCommand("sethub")->setExecutor(new Commands\SetHub($this));
        $this->getCommand("hub")->setExecutor(new Commands\Hub($this));
        $this->getCommand("setspawn")->setExecutor(new Commands\SetSpawn($this));
        $this->getCommand("spawn")->setExecutor(new Commands\Spawn($this));
        $this->getCommand("setalias")->setExecutor(new Commands\SetAlias($this));
        $this->getCommand("mspawns")->setExecutor(new Commands\Commands($this));
    }
    
    public function reloadAliases(){
    	$aliases = new Config($this->getDataFolder() . "aliases.yml", Config::YAML, array());
    	$aliases = $aliases->getAll();
    	foreach($aliases as $cmd => $target){
    		$this->getServer()->getCommandMap()->register($cmd, new Aliases($this, $cmd));
    	}
    }
    
    public function getSpawnMessage(Player $player){
    	if($this->cfg["show-prefix"] === true){
    		$format = Main::PREFIX . $this->cfg["spawn-message"];
    		$format = str_replace("{PLAYER}", $player->getName(), $format);
    		$format = str_replace("{WORLD}", $player->getLevel()->getName(), $format);
    		return $format;
    	}else{
    		$format = $this->cfg["spawn-message"];
    		$format = str_replace("{PLAYER}", $player->getName(), $format);
    		$format = str_replace("{WORLD}", $player->getLevel()->getName(), $format);
    		return $format;
    	}
    }
    
    public function getSpawnMessage_2(Player $player, Level $level){
    	if($this->cfg["show-prefix"] === true){
    		$format = Main::PREFIX . $this->cfg["spawn-message"];
    		$format = str_replace("{PLAYER}", $player->getName(), $format);
    		$format = str_replace("{WORLD}", $level->getName(), $format);
    		return $format;
    	}else{
    		$format = $this->cfg["spawn-message"];
    		$format = str_replace("{PLAYER}", $player->getName(), $format);
    		$format = str_replace("{WORLD}", $level->getName(), $format);
    		return $format;
    	}
    }
    
    public function getNoSpawnMessage(){
    	if($this->cfg["show-prefix"] === true){
    		$format = Main::PREFIX . "&cNo spawn found in this world";
    		return $format;
    	}else{
    		$format = "&cNo spawn found in this world";
    		return $format;
    	}
    }
    
    public function getHubMessage(Player $player){
    	if($this->cfg["show-prefix"] === true){
    		$format = Main::PREFIX . $this->cfg["hub-message"];
    		$format = str_replace("{PLAYER}", $player->getName(), $format);
    		$format = str_replace("{WORLD}", $player->getLevel()->getName(), $format);
    		return $format;
    	}else{
    		$format = $this->cfg["hub-message"];
    		$format = str_replace("{PLAYER}", $player->getName(), $format);
    		$format = str_replace("{WORLD}", $player->getLevel()->getName(), $format);
    		return $format;
    	}
    }
    
    public function getNoHubMessage(){
    	if($this->cfg["show-prefix"] === true){
    		$format = Main::PREFIX . "&cNo hub set";
    		return $format;
    	}else{
    		$format = "&cNo hub set";
    		return $format;
    	}
    }
    
    public function getNoWorldMessage(){
    	if($this->cfg["show-prefix"] === true){
    		$format = Main::PREFIX . "&cWorld not found";
    		return $format;
    	}else{
    		$format = "&cWorld not found";
    		return $format;
    	}
    }
    

    public function getForceSpawn_OnJoin(){
    	return $this->cfg["force-spawn"];
    }
    
    /*public function getForceSpawn(){
    	return $this->cfg["force-spawn"];
    }*/
    
    public function getForceHub_OnJoin(){
    	return $this->cfg["force-hub"];
    }
    
    public function SetAlias($name, $target){
    	$cfg = $this->getConfig()->getAll();
    	$spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
    	$spawns = $spawns->getAll();
    	$aliases = new Config($this->getDataFolder() . "aliases.yml", Config::YAML, array());
    	$temp = $aliases->getAll();
    	$name = strtolower($name);
    	//Check if spawn exists
    	if(isset($spawns[$target])){
    		$temp[$name] = $target;
    		$aliases->setAll($temp);
    		$aliases->save();
    		if($cfg["enable-aliases"] === true){
    			$this->reloadAliases();
    		}
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function getSpawn(Level $level){
    	$spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
    	$spawns = $spawns->getAll();
    	if($this->SpawnExists($level)){
    		return $spawns[$level->getName()];
    	}else{
    		return false;
    	}
    }
    
    public function setSpawn(Player $player){
    	$spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
    	$temp = $spawns->getAll();
    	$temp[$player->getLevel()->getName()]["X"] = $player->x;
    	$temp[$player->getLevel()->getName()]["Y"] = $player->y;
    	$temp[$player->getLevel()->getName()]["Z"] = $player->z;
    	$temp[$player->getLevel()->getName()]["Yaw"] = $player->yaw;
    	$temp[$player->getLevel()->getName()]["Pitch"] = $player->pitch;
    	$player->sendMessage($this->translateColors("&", Main::PREFIX . "&aSpawn set"));
    	$spawns->setAll($temp);
    	$spawns->save();
    }
    
    public function SpawnExists(Level $level){
    	$spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
    	$spawns = $spawns->getAll();
    	return isset($spawns[$level->getName()]);
    }
    
    public function getHub(){
    	$temp = $this->getConfig()->getAll();
    	if($this->HubExists()){
    		return $temp["hub"];
    	}else{
    		return false;
    	}
    }
    
    public function setHub(Player $player){
    	$temp = $this->getConfig()->getAll();
    	$temp["hub"]["world"] = $player->getLevel()->getName();
    	$temp["hub"]["X"] = $player->x;
    	$temp["hub"]["Y"] = $player->y;
    	$temp["hub"]["Z"] = $player->z;
    	$temp["hub"]["Yaw"] = $player->yaw;
    	$temp["hub"]["Pitch"] = $player->pitch;
    	$player->sendMessage($this->translateColors("&", Main::PREFIX . "&aHub set"));
    	$this->getConfig()->setAll($temp);
    	$this->getConfig()->save();
    }
    
    public function HubExists(){
    	return isset($this->cfg["hub"]);
    }
    
    public function teleportToSpawn(Player $player){
    	$spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
    	$spawns = $spawns->getAll();
    	if(isset($spawns[$player->getLevel()->getName()])){
    		$player->teleport(new Position($spawns[$player->getLevel()->getName()]["X"], $spawns[$player->getLevel()->getName()]["Y"], $spawns[$player->getLevel()->getName()]["Z"]), $spawns[$player->getLevel()->getName()]["Yaw"], $spawns[$player->getLevel()->getName()]["Pitch"]);
    		if($this->cfg["enable-spawn-message"] === true){
    			$player->sendMessage($this->translateColors("&", $this->getSpawnMessage($player)));
    		}
    	}else{
    		$player->sendMessage($this->translateColors("&", $this->getNoSpawnMessage()));
    	}
    	return true;
    }
    
    public function teleportToSpawn_2(Player $player, Level $level){
    	$spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
    	$spawns = $spawns->getAll();
    	if(isset($spawns[$level->getName()])){
    		$player->teleport(new Position($spawns[$level->getName()]["X"], $spawns[$level->getName()]["Y"], $spawns[$level->getName()]["Z"]), $spawns[$level->getName()]["Yaw"], $spawns[$level->getName()]["Pitch"]);
    		if($this->cfg["enable-spawn-message"] === true){
    			$player->sendMessage($this->translateColors("&", $this->getSpawnMessage_2($player, $level)));
    		}
    	}else{
    		$player->sendMessage($this->translateColors("&", $this->getNoSpawnMessage()));
    	}
    	return true;
    }
    
    public function teleportToSpawn_OnJoin(Player $player){
    	$spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
    	$spawns = $spawns->getAll();
    	if(isset($spawns[$player->getLevel()->getName()])){
    		$player->teleport(new Position($spawns[$player->getLevel()->getName()]["X"], $spawns[$player->getLevel()->getName()]["Y"], $spawns[$player->getLevel()->getName()]["Z"]), $spawns[$player->getLevel()->getName()]["Yaw"], $spawns[$player->getLevel()->getName()]["Pitch"]);
    		if($this->cfg["enable-spawn-message"] === true && $this->cfg["show-messages-onjoin"] === true){
    			$player->sendMessage($this->translateColors("&", $this->getSpawnMessage($player)));
    		}
    	}
    	else{
    		$player->sendMessage($this->translateColors("&", $this->getNoSpawnMessage()));
    	}
    }
    
    public function teleportToHub(Player $player){
    	$temp = $this->getConfig()->getAll();
    	if(isset($temp["hub"])){
    		if($player->getLevel()->getName() != $temp["hub"]["world"]){
    			if(Server::getInstance()->loadLevel($temp["hub"]["world"]) != false){
    				$player->teleport(new Position($temp["hub"]["X"], $temp["hub"]["Y"], $temp["hub"]["Z"], $this->getServer()->getLevelByName($temp["hub"]["world"])), $temp["hub"]["Yaw"], $temp["hub"]["Pitch"]);
    				if($temp["enable-hub-message"] === true){
    					$player->sendMessage($this->translateColors("&", $this->getHubMessage($player)));
    				}
    			}else{
    				$player->sendMessage($this->translateColors("&", $this->getNoWorldMessage()));
    			}
    		}else{
    			$player->teleport(new Position($temp["hub"]["X"], $temp["hub"]["Y"], $temp["hub"]["Z"]), $temp["hub"]["Yaw"], $temp["hub"]["Pitch"]);
    			if($temp["enable-hub-message"] === true){
    				$player->sendMessage($this->translateColors("&", $this->getHubMessage($player)));
    			}
    		}
    	}else{
    		$player->sendMessage($this->translateColors("&", $this->getNoHubMessage()));
    	}
    }
    
    public function teleportToHub_OnJoin(Player $player){
    	$temp = $this->getConfig()->getAll();
    	if(isset($temp["hub"])){
    		if($player->getLevel()->getName() != $temp["hub"]["world"]){
    			if(Server::getInstance()->loadLevel($temp["hub"]["world"]) != false){
    				$player->teleport(new Vector3($temp["hub"]["X"], $temp["hub"]["Y"], $temp["hub"]["Z"], $this->getServer()->getLevelByName($temp["hub"]["world"])), $temp["hub"]["Yaw"], $temp["hub"]["Pitch"]);
    				if($temp["enable-hub-message"] === true && $temp["show-messages-onjoin"] === true){
    					$player->sendMessage($this->translateColors("&", $this->getHubMessage($player)));
    				}
    			}else{
    				$player->sendMessage($this->translateColors("&", $this->getNoWorldMessage()));
    			}
    		}else{
    			$player->teleport(new Vector3($temp["hub"]["X"], $temp["hub"]["Y"], $temp["hub"]["Z"]), $temp["hub"]["Yaw"], $temp["hub"]["Pitch"]);
    			if($temp["enable-hub-message"] === true && $temp["show-messages-onjoin"] === true){
    				$player->sendMessage($this->translateColors("&", $this->getHubMessage($player)));
    			}
    		}
    	}else{
    		$player->sendMessage($this->translateColors("&", $this->getNoHubMessage()));
    	}
    }
    	
}

