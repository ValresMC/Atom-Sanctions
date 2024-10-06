<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class AtomSanctions extends PluginBase
{
    use SingletonTrait;

    public function onEnable(): void {
        $this->saveDefaultConfig();
    }

    protected function onLoad(): void {
        self::setInstance($this);
    }
}
