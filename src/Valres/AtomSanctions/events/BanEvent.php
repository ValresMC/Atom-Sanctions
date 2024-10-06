<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions\events;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;
use Valres\AtomSanctions\managers\sanctions\types\Ban;

final class BanEvent extends Event implements Cancellable
{
    use CancellableTrait;

    public function __construct(
        protected readonly Ban $ban
    ) {}

    public function getBan(): Ban {
        return $this->ban;
    }
}
