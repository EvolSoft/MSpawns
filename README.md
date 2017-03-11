![start2](https://cloud.githubusercontent.com/assets/10303538/6315586/9463fa5c-ba06-11e4-8f30-ce7d8219c27d.png)

# MSpawns

Multiple Spawn plugin for PocketMine-MP

## Category

PocketMine-MP plugins

## Requirements

[PocketMine-MP](https://github.com/pmmp/PocketMine-MP) API 2.0.0 - 3.0.0-ALPHA4

## Overview

**MSpawns** is a Multiple Spawn plugin.

**EvolSoft Website:** http://www.evolsoft.tk

***This Plugin uses the New API. You can't install it on old versions of PocketMine.***<br>

***MultiWorld Bugs (for eg. Invisible chunks...) aren't related to plugin or PocketMine but to Minecraft PE.***

You can set a global spawn (hub) and a spawn for each world.<br>
You can also customize spawn settings, spawn messages... and you can also set aliases! (read documentation)

**Commands:**

***/mspawns*** *- MSpawns commands*<br>
***/setalias*** *- Set alias*<br>
***/hub*** *- Teleport to global spawn*<br>
***/sethub*** *- Set global spawn*<br>
***/spawn*** *- Teleport to world spawn*<br>
***/setspawn*** *- Set world spawn*<br>

**To-Do:**

*- Bug fix (if bugs will be found)*

## Documentation

**Configuration (config.yml):**

```yaml
---
# Available Tags for messages:
#  - {PLAYER}: Show current player name
#  - {WORLD}: Show current world name
# Show [MSpawns] prefix
show-prefix: true
# Show hub-message or spawn-message when a player joins
show-messages-onjoin: true
# Force teleportation to hub when a player joins
force-hub: false
# Show message when a player teleports to hub
enable-hub-message: true
# Hub message
hub-message: "Welcome to Hub, {PLAYER}"
# Force teleportation to spawn when a player joins (obviously if you enable force-hub, force-spawn won't work)
force-spawn: false
# Show message when a player teleports to spawn
enable-spawn-message: true
# Spawn message
spawn-message: "Teleported To {WORLD} Spawn"
# Enable aliases usage
enable-aliases: true
# Teleport a player to the spawn/hub when they die
# 1 = Teleport to spawn 2 = Teleport to Hub
teleport-on-death: 1
...
```

**Aliases:**

With aliases you can create commands that teleport players.<br>
You can manually edit them in aliases.yml file.<br>
If you want to create an alias you must specify the name and the target world (remember that the target world must have a spawn set)<br>
*Example usage:*
Imagine that you have a world called "pvpworld" and you want to set an alias called "pvp".<br>
1. Set spawn in world "pvpworld" with /setspawn<br>
2. Do /setalias pvp pvpworld<br>
To use the alias you must simply do /pvp and you will be teleported to "pvpworld" spawn<br>

*Remember that you can use aliases only if you set to true the value of "enable-aliases" in config.yml*

**Commands:**

***/mspawns*** *- MSpawns commands (aliases: [ms])*<br>
***/setalias <name> <target>*** *- Set alias*<br>
***/hub*** *- Teleport to global spawn*<br>
***/sethub*** *- Set global spawn*<br>
***/spawn*** *- Teleport to world spawn*<br>
***/setspawn*** *- Set world spawn*<br>

**Permissions:**

- <dd><i><b>mspawns.*</b> - MSpawns commands permissions.</i></dd>
- <dd><i><b>mspawns.info</b> - Allows player to read info about MSpawns.</i></dd>
- <dd><i><b>mspawns.reload</b> - Allows player to reload MSpawns.</i></dd>
- <dd><i><b>mspawns.sethub</b> - Allows player to set hub.</i></dd>
- <dd><i><b>mspawns.hub</b> - Teleport player to hub.</i></dd>
- <dd><i><b>mspawns.setalias</b> - Allows player to set alias.</i></dd>
- <dd><i><b>mspawns.setspawn</b> - Allows player to set spawn.</i></dd>
- <dd><i><b>mspawns.spawn</b> - Teleport player to world spawn.</i></dd>
