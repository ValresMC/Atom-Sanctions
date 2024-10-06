<?php

/**
 *    _____   __                           ________
 *   /  _  \_/  |_  ____   _____           \______ \   _______  __
 *  /  /_\  \   __\/  _ \ /     \   ______  |    |  \_/ __ \  \/ /
 * /    |    \  | (  (_) )  Y Y  \ /_____/  |    `   \  ___/\   /
 * \____|____/__|  \____/|__|_|__/         /_________/\_____>\_/
 *
 * @author ValresMC
 * @version v0.0.1
 */

declare(strict_types=1);

namespace Valres\AtomSanctions\managers\commands;

use pocketmine\command\Command;
use pocketmine\command\SimpleCommandMap;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use Valres\AtomSanctions\commands\BanCommand;

class CommandsManager
{
    use SingletonTrait;

    private SimpleCommandMap $factory;

    public function load(): void {
        $this->factory = Server::getInstance()->getCommandMap();
        $this->unenregisterCommands();

        $this->factory->registerAll("sanctions", [
            new BanCommand()
        ]);
    }

    public function unenregisterCommands(): void {
        $commands = ["ban", "unban", "kick"];

        foreach($commands as $command){
            $cmd = $this->factory->getCommand($command);
            if($cmd instanceof Command){
                $this->factory->unregister($cmd);
            }
        }
    }
}