<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions;

use pocketmine\plugin\PluginBase;

class AtomSanctions extends PluginBase
{
    public function onEnable(): void {
        $this->saveDefaultConfig();
    }
}
