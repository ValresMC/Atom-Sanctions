<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions;

use JsonException;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
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
    }

    protected function onLoad(): void {
        self::setInstance($this);
    }

    /** @throws JsonException */
    protected function onDisable(): void {
        SanctionsManager::getInstance()->save();
    }
}
