<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions\events;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;
use Valres\AtomSanctions\managers\sanctions\types\Mute;

final class MuteEvent extends Event implements Cancellable
{
    use CancellableTrait;

    public function __construct(
        protected readonly Mute $mute
    ) {}

    public function getMute(): Mute {
        return $this->mute;
    }
}
