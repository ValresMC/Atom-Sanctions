<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions\events;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;
use Valres\AtomSanctions\managers\sanctions\types\Ban;

class PlayerBanEvent extends Event implements Cancellable
{
    use CancellableTrait;

    public function __construct(
        protected string $playerName,
        protected Ban $ban
    ) {}

    public function getPlayerName(): string {
        return $this->playerName;
    }

    public function getBan(): Ban {
        return $this->ban;
    }
}
