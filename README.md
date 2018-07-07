![start2](https://cloud.githubusercontent.com/assets/10303538/6315586/9463fa5c-ba06-11e4-8f30-ce7d8219c27d.png)

# MSpawns

Multiple spawns plugin for PocketMine-MP

## Category

PocketMine-MP plugins

## Requirements

PocketMine-MP API 3.0.0

## Overview

**MSpawns** let you set multiple spawns on your PocketMine-MP server.

**EvolSoft Website:** https://www.evolsoft.tk

***This Plugin uses the New API. You can't install it on old versions of PocketMine.***

***MultiWorld Bugs (for eg. Invisible chunks...) aren't related to plugin or PocketMine but to Minecraft PE.***

You can set a global spawn (hub/lobby) and a spawn for each world.
You can also customize spawn settings, spawn messages... and you can also set aliases! (read documentation)

## Donate

Please support the development of this plugin with a small donation by clicking [:dollar: here](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=flavius.c.1999@gmail.com&lc=US&item_name=www.evolsoft.tk&no_note=0&cn=&curency_code=EUR&bn=PP-DonationsBF:btn_donateCC_LG.gif:NonHosted). 
Your small donation will help me paying web hosting, domains, buying programs (such as IDEs, debuggers, etc...) and new hardware to improve software development. Thank you :smile:

## Documentation

**Configuration (config.yml):**

```yaml
---
# Available Tags for messages:
#  - {PLAYER}: Show current player name
#  - {PREFIX}: Show plugin prefix
#  - {WORLD}: Show current world name
# Show hub-message or spawn-message when a player joins
show-messages-onjoin: true
# Force teleportation to hub when a player joins
force-hub: false
# Show message when a player teleports to hub
enable-hub-message: true
# Force teleportation to spawn when a player joins (obviously if you enable force-hub, force-spawn won't work)
force-spawn: false
# Show message when a player teleports to spawn
enable-spawn-message: true
# Enable aliases usage
enable-aliases: true
# Teleport a player to the spawn/hub when they die
# 1 = Teleport to spawn 2 = Teleport to Hub
teleport-on-death: 1
# External hub server 
hub-server:
 # Enable external hub server
 enabled: false
 # Name of the hub server
 name: "External Server"
 # Hostname of the hub server
 host: 127.0.0.1
 # Port of the hub server (default 19132)
 port: 19132
```

**Messages (messages.yml):**

```yaml
---
#Hub message
hub-message: "{PREFIX} &bWelcome to Hub, &a{PLAYER}"
#No hub message
no-hub: "{PREFIX} &cNo hub set"
#Spawn message
spawn-message: "{PREFIX} &bTeleported to &e{WORLD}&b Spawn"
#No spawn message
no-spawn: "{PREFIX} &cNo spawn found in this world"
#Invalid world
invalid-world: "{PREFIX} &cWorld not found"
#Spawn aliases disabled
aliases-disabled: "{PREFIX} &cSpawn aliases are disabled on this server"
...
```

**Commands:**

***/mspawns*** *- MSpawns commands (aliases: [ms])*<br>
***/sethub*** *- Set hub (aliases: [setlobby])*<br>
***/delhub*** *- Delete hub (aliases: [dellobby])*<br>
***/hub*** *- Teleport to hub (aliases: [lobby])*<br>
***/setspawn*** *- Set world spawn*<br>
***/delspawn*** *- Delete world spawn*<br>
***/spawn*** *- Teleport to world spawn*<br>
***/setalias*** *- Set alias <name> <target>*<br>
***/delalias*** *- Delete alias <name>*<br>

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

**Permissions:**

- <dd><i><b>mspawns.*</b> - MSpawns permissions tree.</i></dd>
- <dd><i><b>mspawns.info</b> - Let player read info about MSpawns.</i></dd>
- <dd><i><b>mspawns.reload</b> - Let player reload MSpawns.</i></dd>
- <dd><i><b>mspawns.delhub</b> - Let player delete hub.</i></dd>
- <dd><i><b>mspawns.sethub</b> - Let player set hub.</i></dd>
- <dd><i><b>mspawns.hub</b> - Let player teleport to hub.</i></dd>
- <dd><i><b>mspawns.delalias</b> - Let player delete alias.</i></dd>
- <dd><i><b>mspawns.setalias</b> - Let player set alias.</i></dd>
- <dd><i><b>mspawns.delspawn</b> - Let player delete world spawn.</i></dd>
- <dd><i><b>mspawns.setspawn</b> - Let player set world spawn.</i></dd>
- <dd><i><b>mspawns.spawn</b> - Let player teleport to world spawn.</i></dd>