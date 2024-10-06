<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions\events;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;

class PlayerBanEvent extends Event implements Cancellable
{
    use CancellableTrait;

    public function __construct(
        protected string $playerName,
        protected int $time,
        protected string $reason,
        protected string $authorName
    ) {}

    public function getPlayerName(): string {
        return $this->playerName;
    }

    public function getTime(): int {
        return $this->time;
    }

    public function getReason(): string {
        return $this->reason;
    }

    public function getAuthorName(): string {
        return $this->authorName;
    }
}
