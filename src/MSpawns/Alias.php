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
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Alias extends AliasesMap {
    
    public function __construct(MSpawns $plugin, $command, $desc){
        parent::__construct($plugin, $command, $desc);
        $this->cmd = $command;
        $this->plugin = $plugin;
    }
    
    public function execute(CommandSender $sender, $label, array $args) : bool {
        if($sender instanceof Player){
            if(!$this->plugin->cfg["enable-aliases"]){
                $sender->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("aliases-disabled"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName()))));
                return true;
            }
            if($sender->hasPermission("mspawns.spawn")){
                if(($dest = $this->plugin->getAlias($this->cmd)) != false){
                    if(Server::getInstance()->loadLevel($dest)){
                        $level = Server::getInstance()->getLevelByName($dest);
                        if($this->plugin->teleportToSpawn($sender, $level)){
                            if($this->plugin->isSpawnMessageEnabled()){
                                $sender->sendMessage(TextFormat::colorize($this->plugin->getFormattedSpawnMessage($sender)));
                            }
                        }else{
                            $sender->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("no-spawn"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $level->getName()))));
                        }
                    }else{
                        $sender->sendMessage(TextFormat::colorize($this->plugin->replaceVars($this->plugin->getMessage("invalid-world"), array("PREFIX" => MSpawns::PREFIX, "PLAYER" => $sender->getName(), "WORLD" => $dest))));
                    }
                }else{
                    $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c No alias"));
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