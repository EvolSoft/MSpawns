<?php

/*
 * MSpawns (v2.0) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: https://www.evolsoft.tk
 * Date: 07/01/2018 04:28 PM (UTC)
 * Copyright & License: (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Alias extends AliasesMap {
    
    public function __construct(MSpawns $plugin, $command, $desc){
        parent::__construct($plugin, $command, $desc);
        $this->cmd = $command;
        $this->plugin = $plugin;
    }
    
    public function execute(CommandSender $sender, $label, array $args) : bool {
        if($sender instanceof Player){
            if(!$this->plugin->cfg["enable-aliases"]){
                $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->replaceVars($this->plugin->getMessage("aliases-disabled"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName()))));
                return true;
            }
            if($sender->hasPermission("mspawns.spawn")){
                if(($dest = $this->plugin->getAlias($this->cmd)) != false){
                    if(Server::getInstance()->loadLevel($dest)){
                        $level = Server::getInstance()->getLevelByName($dest);
                        if($this->plugin->teleportToSpawn($sender, $level)){
                            if($this->plugin->isSpawnMessageEnabled()){
                                $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->getFormattedSpawnMessage($sender)));
                            }
                        }else{
                            $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->replaceVars($this->plugin->getMessage("no-spawn"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $level->getName()))));
                        }
                    }else{
                        $sender->sendMessage($this->plugin->translateColors("&", $this->plugin->replaceVars($this->plugin->getMessage("invalid-world"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $dest))));
                    }
                }else{
                    $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c No alias"));
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