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

namespace Valres\AtomSanctions\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use Valres\AtomSanctions\AtomSanctions;
use Valres\AtomSanctions\managers\sanctions\SanctionsManager;
use Valres\AtomSanctions\utils\TimeHelper;

class PlayerPreLogin implements Listener
{
    public function onEvent(PlayerPreLoginEvent $event): void {
        $playerName = $event->getPlayerInfo()->getUsername();
        $sanctionManager = SanctionsManager::getInstance();
        $config = AtomSanctions::getInstance()->getConfig();

        if($sanctionManager->isBanned($playerName)){
            $ban = SanctionsManager::getInstance()->getBan($playerName);
            if($ban->getTime() < time()){
                $sanctionManager->deleteBan($playerName);
                return;
            }

            $event->setKickFlag(PlayerPreLoginEvent::KICK_FLAG_BANNED, str_replace(
                ["{reason}", "{remaining}", "{author}"],
                [$ban->getReason(), TimeHelper::timeToString($ban->getTime()), $ban->getAuthorName()],
                $config->get("ban-screen")
            ));
        }
    }
}
