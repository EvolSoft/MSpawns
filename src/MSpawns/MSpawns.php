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
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class MSpawns extends PluginBase {

    /** @var string */
	const PREFIX = "&7[&cMSpawns&7]";
	
	/** @var string */
	const API_VERSION = "2.0";
	
	/** @var array */
    public $cfg;
    
    /** @var Config */
    public $aliases;
	
    /** @var Config */
	public $spawns;
	
	/** @var Config */
	private $messages;
	
	/** @var int */
	const SUCCESS = 1;
	
	/** @var int */
	const ERR_NO_HUB = 2;
	
	/** @var int */
	const ERR_HUB_INVALID_WORLD = 3;
	
	/** @var int */
	const ERR_HUB_TRANSFER = 4;

	/** @var MSpawns */
	private static $instance = null;
	
	public function onLoad(){
	    if(!self::$instance instanceof MSpawns){
	        self::$instance = $this;
	    }
	}
	
    public function onEnable(){
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->saveResource("aliases.yml");
        $this->saveResource("spawns.yml");
        $this->saveResource("messages.yml");
        $this->aliases = new Config($this->getDataFolder() . "aliases.yml", Config::YAML, array());
        $this->spawns = new Config($this->getDataFolder() . "spawns.yml", Config::YAML, array());
        $this->messages = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
        $this->cfg = $this->getConfig()->getAll();
        $this->getCommand("delhub")->setExecutor(new Commands\DelHub($this));
        $this->getCommand("sethub")->setExecutor(new Commands\SetHub($this));
        $this->getCommand("hub")->setExecutor(new Commands\Hub($this));
        $this->getCommand("delspawn")->setExecutor(new Commands\DelSpawn($this));
        $this->getCommand("setspawn")->setExecutor(new Commands\SetSpawn($this));
        $this->getCommand("spawn")->setExecutor(new Commands\Spawn($this));
        $this->getCommand("delalias")->setExecutor(new Commands\DelAlias($this));
        $this->getCommand("setalias")->setExecutor(new Commands\SetAlias($this));
        $this->getCommand("mspawns")->setExecutor(new Commands\Commands($this));
        if($this->cfg["enable-aliases"]){
        	$this->reloadAliases();
        }
	    $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
    
    /**
     * Get MSpawns API
     *
     * @return MSpawns
     */
    public static function getAPI(){
        return self::$instance;
    }
    
    /**
     * Get MSpawns version
     *
     * @return string
     */
    public function getVersion(){
        return $this->getVersion();
    }
    
    /**
     * Get MSpawns API version
     *
     * @return string
     */
    public function getAPIVersion(){
        return self::API_VERSION;
    }
    
    /**
     * Reload MSpawns configuration
     */
    public function reload(){
        $this->reloadConfig();
        $this->cfg = $this->getConfig()->getAll();
        $this->spawns->reload();
        $this->aliases->reload();
        if($this->cfg["enable-aliases"]){
            $this->reloadAliases();
        }
    }
    
    /**
     * Set world spawn
     * 
     * @param Level $level
     * @param int $x
     * @param int $y
     * @param int $z
     * @param float $yaw
     * @param float $pitch
     */
    public function setSpawn(Level $level, $x, $y, $z, $yaw, $pitch){
        $temp = array("X" => $x, "Y" => $y, "Z" => $z, "Yaw" => $yaw, "Pitch" => $pitch);
        $this->spawns->set($level->getName(), $temp);
        $this->spawns->save();
    }
    
    /**
     * Get world spawn
     *
     * @param Level $level
     * 
     * @return string|bool
     */
    public function getSpawn(Level $level){
        if($this->spawnExists($level)){
            return $this->spawns->get($level->getName());
        }
        return false;
    }
    
    /**
     * Remove world spawn
     * 
     * @param Level $level
     * 
     * @return bool
     */
    public function removeSpawn($level) : bool {
        if($this->spawns->exists($level)){
            $this->spawns->remove($level);
            $this->spawns->save();
            return true;
        }
        return false;
    }
    
    /**
     * Check if spawn exists in the specified world
     * 
     * @param Level $level
     * 
     * @return bool
     */
    public function spawnExists(Level $level) : bool {
        return $this->spawns->exists($level->getName());
    }
    
    /**
     * Teleport player to spawn
     *
     * @param Player $player
     * @param Level $level
     * 
     * @return bool
     */
    public function teleportToSpawn(Player $player, Level $level = null) : bool {
        if($level){
            $lvl = $level;
        }else{
            $lvl = $player->getLevel();
        }
        if($this->spawnExists($lvl)){
            $spawn = $this->getSpawn($lvl);
            $player->teleport(new Position($spawn["X"], $spawn["Y"], $spawn["Z"], ($level == null) ? null : $lvl), $spawn["Yaw"], $spawn["Pitch"]);
            return true;
        }
        return false;
    }
    
    /**
     * Check if force spawn is enabled in config
     * 
     * @return bool
     */
    public function isForceSpawnEnabled() : bool {
        return $this->cfg["force-spawn"];
    }
    
    /**
     * Check if spawn message is enabled in config
     * 
     * @return bool
     */
    public function isSpawnMessageEnabled() : bool {
        return $this->cfg["enable-spawn-message"];
    }
    
    /**
     * Get formatted spawn message
     * 
     * @param Player $player
     * @param Level $level
     * 
     * @return string
     */
    public function getFormattedSpawnMessage(Player $player, Level $level = null) : string {
        if(!$level){
            $level = $player->getLevel();
        }
        return $this->replaceVars($this->getMessage("spawn-message"), array("PREFIX" => self::PREFIX, "PLAYER" => $player->getName(), "WORLD" => $level->getName()));
    }
    
    /**
     * Set hub
     * 
     * @param Level $level
     * @param int $x
     * @param int $y
     * @param int $z
     * @param float $yaw
     * @param float $pitch
     */
    public function setHub(Level $level, $x, $y, $z, $yaw, $pitch){
        $this->cfg["hub"]["world"] = $level->getName();
        $this->cfg["hub"]["X"] = $x;
        $this->cfg["hub"]["Y"] = $y;
        $this->cfg["hub"]["Z"] = $z;
        $this->cfg["hub"]["Yaw"] = $yaw;
        $this->cfg["hub"]["Pitch"] = $pitch;
        $this->getConfig()->setAll($this->cfg);
        $this->getConfig()->save();
    }
    
    /**
     * Get current hub
     *
     * @return mixed|bool
     */
    public function getHub(){
        if($this->hubExists()){
            if($this->isHubExternal()){
                return $this->cfg["hub-server"];
            }
            return $this->cfg["hub"];
        }
        return false;
    }
    
    /**
     * Remove hub
     * 
     * @return bool
     */
    public function removeHub() : bool {
        if($this->hubExists()){
            if($this->isHubExternal()){
                $this->cfg["hub-server"]["enabled"] = false;
            }
            if(isset($this->cfg["hub"])){
                unset($this->cfg["hub"]);
            }
            $this->getConfig()->setAll($this->cfg);
            $this->getConfig()->save();
            return true;
        }
        return false;
    }
    
    /**
     * Check if hub exists
     *
     * @return bool
     */
    public function hubExists() : bool {
        if($this->isHubExternal()){
            return true;
        }
        return isset($this->cfg["hub"]);
    }
    
    /**
     * Teleport player to hub
     * 
     * @param Player $player
     * 
     * @return int
     */
    public function teleportToHub(Player $player) : int {
        if(!$this->hubExists()){
            return self::ERR_NO_HUB;
        }
        $hub = $this->getHub();
        if($this->isHubExternal()){
            return $player->transfer($hub["host"], $hub["port"]) ? self::SUCCESS : self::ERR_HUB_TRANSFER;
        }
        if(strcasecmp($player->getLevel()->getName(), $hub["world"]) != 0){
            if(!Server::getInstance()->loadLevel($hub["world"])){
                return self::ERR_HUB_INVALID_WORLD;
            }
            $level = $this->getServer()->getLevelByName($hub["world"]);
            $player->teleport(new Position($hub["X"], $hub["Y"], $hub["Z"], $level), $hub["Yaw"], $hub["Pitch"]);
            return self::SUCCESS;
        }
        $player->teleport(new Position($hub["X"], $hub["Y"], $hub["Z"]), $hub["Yaw"], $hub["Pitch"]);
        return self::SUCCESS;
    }
    
    /**
     * Check if force hub is enabled in config
     *
     * @return bool
     */
    public function isForceHubEnabled() : bool {
        return $this->cfg["force-hub"];
    }
    
    /**
     * Check if hub message is enabled in config
     *
     * @return bool
     */
    public function isHubMessageEnabled() : bool {
        return $this->cfg["enable-hub-message"];
    }
    
    /**
     * Check if the hub is an external server
     *
     * @return bool
     */
    public function isHubExternal() : bool {
        return $this->cfg["hub-server"]["enabled"];
    }
    
    /**
     * Get hub name
     * 
     * @return string
     */
    public function getHubName() : ?string {
        if($this->hubExists()){
            if($this->isHubExternal()){
                return $this->cfg["hub-server"]["name"];
            }
            return $this->cfg["hub"]["world"];
        }
        return null;
    }
    
    /**
     * Get formatted hub message
     * 
     * @param Player $player
     * 
     * @return string
     */
    public function getFormattedHubMessage(Player $player) : string {
        return $this->replaceVars($this->getMessage("hub-message"), array("PREFIX" => self::PREFIX, "PLAYER" => $player->getName(), "WORLD" => $this->getHubName()));
    }
    
    /**
     * Reload aliases
     */
    public function reloadAliases(){
        foreach($this->aliases->getAll() as $cmd => $target){
            $this->getServer()->getCommandMap()->register($cmd, new Alias($this, $cmd, "MSpawns alias for world " . $target . "'s spawn"));
        }
    }
    
    /**
     * Check if alias exists
     * 
     * @param string $id
     * 
     * @return bool
     */
    public function aliasExists($id) : bool {
        return $this->aliases->exists($id);
    }
    
    /**
     * Set alias
     * 
     * @param string $id
     * @param string $target
     * 
     * @return bool
     */
    public function setAlias($id, $target) : bool {
        if(!$this->spawns->exists($target)){
            return false;
        }
        $this->aliases->set($id, $target);
        $this->aliases->save();
        $this->getServer()->getCommandMap()->register($id, new Alias($this, $id, "MSpawns alias for world " . $target . "'s spawn"));
        return true;
    }
    
    /**
     * Get alias
     * 
     * @param string $id
     * 
     * @return mixed|bool
     */
    public function getAlias($id){
        if($this->aliasExists($id)){
            return $this->aliases->get($id);
        }
        return false;
    }
    
    /**
     * Remove alias
     * 
     * @param string $id
     * 
     * @return bool
     */
    public function removeAlias($id) : bool {
        if(!$this->aliasExists($id)){
            return false;
        }
        $this->aliases->remove($id);
        $this->aliases->save();
        $cmd = $this->getServer()->getCommandMap()->getCommand($id);
        if($cmd){
            $this->getServer()->getCommandMap()->unregister($cmd);
        }
        return true;
    }
    
    /**
     * Get MSpawns message
     * 
     * @param string $id
     * 
     * @return string|bool
     */
    public function getMessage($id){
        if($this->messages->exists($id)){
            return $this->messages->get($id);
        }
        return false;
    }
    
    /**
     * Replace variables inside a string
     * 
     * @param string $str
     * @param array $vars
     * 
     * @return string
     */
    public function replaceVars($str, array $vars){
        foreach($vars as $key => $value){
            $str = str_replace("{" . $key . "}", $value, $str);
        }
        return $str;
    }
}