<?php

/*
 * MSpawns v2.2 by EvolSoft
 * Developer: Flavius12
 * Website: https://www.evolsoft.tk
 * Copyright (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;

use MSpawns\MSpawns;

class DelAlias extends PluginCommand implements CommandExecutor {
    
    /** @var MSpawns */
    private $plugin;
    
    public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
        if($sender->hasPermission("mspawns.delalias")){
            if(isset($args[0])){
                if($this->plugin->removeAlias($args[0])){
                    $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&a Alias " . $args[0] . " removed"));
                }else{
                    $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c Alias " . $args[0] . " doesn't exist"));
                }
            }else{
                $sender->sendMessage(TextFormat::colorize(MSpawns::PREFIX . "&c Usage /delalias <alias>"));
            }
        }else{
            $sender->sendMessage(TextFormat::colorize("&cYou don't have permissions to use this command"));
        }
        return true;
    }
}
