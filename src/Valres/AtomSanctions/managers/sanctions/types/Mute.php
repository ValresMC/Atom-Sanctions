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

namespace Valres\AtomSanctions\managers\sanctions\types;

use Valres\AtomSanctions\managers\sanctions\Sanction;

class Mute extends Sanction
{
    public function toArray(): array {
        return [
            "playerName" => $this->playerName,
            "time" => $this->time,
            "reason" => $this->reason,
            "authorName" => $this->authorName
        ];
    }

    public static function fromArray(array $data): self {
        return new self(
            $data["playerName"],
            $data["time"],
            $data["reason"],
            $data["authorName"]
        );
    }
}
