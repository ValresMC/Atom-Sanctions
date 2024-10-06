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
use pocketmine\event\player\PlayerChatEvent;
use Valres\AtomSanctions\AtomSanctions;
use Valres\AtomSanctions\managers\sanctions\SanctionsManager;
use Valres\AtomSanctions\utils\TimeHelper;

class PlayerChat implements Listener
{
    public function onEvent(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $playerName = $player->getName();
        $sanctionsManager = SanctionsManager::getInstance();
        $config = AtomSanctions::getInstance()->getConfig();

        if($sanctionsManager->isMuted($playerName)){
            $mute = $sanctionsManager->getMute($playerName);
            if($mute->getTime() < time()){
                $sanctionsManager->deleteMute($playerName);
                return;
            }

            $event->cancel();
            $player->sendMessage(str_replace(
                ["{reason}", "{remaining}", "{author}"],
                [$mute->getReason(), TimeHelper::timeToString($mute->getTime()), $mute->getAuthorName()],
                $config->get("mute-screen")
            ));
        }
    }
}
