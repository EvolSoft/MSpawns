<?php

/*
 * MSpawns v2.2 by EvolSoft
 * Developer: Flavius12
 * Website: https://www.evolsoft.tk
 * Copyright (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;

use MSpawns\MSpawns;

class DelSpawn extends PluginCommand implements CommandExecutor {
    
    /** @var MSpawns */
    private $plugin;
    
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
                            $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&a Spawn removed on world &e" . $level));
                        }else{
                            $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c No spawn found on world " . $level));
                        }
                }else{
                    $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c Usage /delspawn <world>"));
                }
            }
        }else{
            $sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
        }
        return true;
    }
}
