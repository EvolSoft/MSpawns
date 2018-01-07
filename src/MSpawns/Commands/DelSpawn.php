<?php

/*
 * MSpawns (v2.0) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: https://www.evolsoft.tk
 * Date: 07/01/2018 04:29 PM (UTC)
 * Copyright & License: (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

use MSpawns\MSpawns;

class DelSpawn extends PluginBase implements CommandExecutor {
    
    public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
        if($sender->hasPermission("mspawns.delspawn")){
            if(isset($args[0])){
                $level = $args[0];
                goto delspw;
            }else{
                if($sender instanceof Player){
                    $level = $sender->getLevel()->getName();
                    delspw:
                        if($this->plugin->removeSpawn($level)){
                            $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&a Spawn removed on world &e" . $level));
                        }else{
                            $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c No spawn found on world " . $level));
                        }
                }else{
                    $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c Usage /delspawn <world>"));
                }
            }
        }else{
            $sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
        }
        return true;
    }
}