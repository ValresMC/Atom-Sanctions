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

namespace Valres\AtomSanctions\managers\sanctions;

class Sanction
{
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