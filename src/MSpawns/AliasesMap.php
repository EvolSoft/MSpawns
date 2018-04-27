<?php

/*
 * MSpawns (v2.1) by EvolSoft
 * Developer: EvolSoft (Flavius12)
 * Website: https://www.evolsoft.tk
 * Date: 07/01/2018 04:28 PM (UTC)
 * Copyright & License: (C) 2014-2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/MSpawns/blob/master/LICENSE)
 */

namespace MSpawns;

use pocketmine\command\Command;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;

abstract class AliasesMap extends Command implements PluginIdentifiableCommand {
    
    public function __construct(MSpawns $plugin, $name, $desc){
        parent::__construct($name, $desc);
        $this->plugin = $plugin;
    }
    
    public function getPlugin() : Plugin {
        return $this->plugin;
    }
}