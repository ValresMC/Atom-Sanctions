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
use pocketmine\permission\PermissionManager;
use pocketmine\Server;
use Valres\AtomSanctions\AtomSanctions;
use Valres\AtomSanctions\managers\sanctions\SanctionsManager;

class UnbanCommand extends Command
{
    public function __construct() {
        parent::__construct("unban", "Unban a player", "usage : /unban <player>");
        DefaultPermissions::registerPermission(new Permission("sanction.unban.command", "Unban a player"), [PermissionManager::getInstance()->getPermission(DefaultPermissions::ROOT_OPERATOR)]);
        $this->setPermission("sanction.unban.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        $sanctionsManager = SanctionsManager::getInstance();
        $config = AtomSanctions::getInstance()->getConfig();
        if(count($args) < 1){
            $sender->sendMessage($this->getUsage());
            return;
        }

        $targetName = $args[0];

        if(!$sanctionsManager->isBanned($targetName)){
            $sender->sendMessage($config->get("player-not-ban"));
            return;
        }

        $sanctionsManager->deleteBan($targetName);
        Server::getInstance()->broadcastMessage(str_replace(
            ["{player}", "{author}"],
            [$targetName, $sender->getName()],
            $config->get("unban-message")
        ));
    }
}