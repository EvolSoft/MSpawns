<?php

/*
 * MSpawns (v2.1) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: https://www.evolsoft.tk
 * Date: 07/01/2018 04:30 PM (UTC)
 * Copyright & License: (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns\Commands;

use pocketmine\command\Command;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;

use MSpawns\MSpawns;

class DelAlias extends PluginCommand implements CommandExecutor {
    
    public function __construct(MSpawns $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) : bool {
        if($sender->hasPermission("mspawns.delalias")){
            if(isset($args[0])){
                if($this->plugin->removeAlias($args[0])){
                    $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&a Alias " . $args[0] . " removed"));
                }else{
                    $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c Alias " . $args[0] . " doesn't exist"));
                }
            }else{
                $sender->sendMessage($this->plugin->translateColors("&", MSpawns::PREFIX . "&c Usage /delalias <alias>"));
            }
        }else{
            $sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
        }
        return true;
    }
}
