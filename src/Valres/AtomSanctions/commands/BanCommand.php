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

namespace Valres\AtomSanctions\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\permission\Permission;
use pocketmine\player\Player;
use pocketmine\Server;
use Valres\AtomSanctions\AtomSanctions;
use Valres\AtomSanctions\managers\sanctions\SanctionsManager;
use Valres\AtomSanctions\managers\sanctions\types\Ban;
use Valres\AtomSanctions\utils\TimeHelper;

class BanCommand extends Command
{
    public function __construct() {
        parent::__construct("ban", "Ban a player", "usage : /ban <player> <time> <?reason>");
        DefaultPermissions::registerPermission(new Permission("sanction.ban.command", "Ban a player", [DefaultPermissions::ROOT_OPERATOR]));
        $this->setPermission("sanction.ban.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        $sanctionsManager = SanctionsManager::getInstance();
        $config = AtomSanctions::getInstance()->getConfig();
        if(count($args) < 2){
            $sender->sendMessage($this->getUsage());
            return;
        }

        $targetName = $args[0];
        $time = TimeHelper::stringToTime($args[1]);
        $reason = isset($args[2]) ? implode(" ", array_slice($args, 2)) : "No reason";

        if($sanctionsManager->isBanned($targetName)){
            $sender->sendMessage($config->get("player-already-ban"));
            return;
        }

        $ban = new Ban($targetName, $time, $reason, $sender->getName());
        $sanctionsManager->addBan($ban, true);
        $target = Server::getInstance()->getPlayerExact($targetName);
        if($target instanceof Player){
            $target->kick(str_replace(
                ["{reason}", "{remaining}", "{author}"],
                [$reason, TimeHelper::timeToString($time), $sender->getName()],
                $config->get("ban-screen")
            ));
        }
    }
}