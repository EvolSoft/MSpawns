<?php

/*
 * MSpawns v2.2 by EvolSoft
 * Developer: Flavius12
 * Website: https://www.evolsoft.tk
 * Copyright (C) 2014-2018 EvolSoft
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