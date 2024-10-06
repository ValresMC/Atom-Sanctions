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

declare(strict_types = 1);

namespace Valres\AtomSanctions;

use JsonException;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Valres\AtomSanctions\managers\commands\CommandsManager;
use Valres\AtomSanctions\managers\files\FilesManager;
use Valres\AtomSanctions\managers\sanctions\SanctionsManager;

class AtomSanctions extends PluginBase
{
    use SingletonTrait;

    /** @throws JsonException */
    public function onEnable(): void {
        $this->saveDefaultConfig();

        FilesManager::getInstance()->load();
        SanctionsManager::getInstance()->load();
        CommandsManager::getInstance()->load();
    }

    protected function onLoad(): void {
        self::setInstance($this);
    }

    /** @throws JsonException */
    protected function onDisable(): void {
        SanctionsManager::getInstance()->save();
    }
}
