<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions\managers;

use Valres\AtomSanctions\events\PlayerBanEvent;
use Valres\AtomSanctions\events\PlayerMuteEvent;
use Valres\AtomSanctions\managers\sanctions\types\Ban;
use Valres\AtomSanctions\managers\sanctions\types\Mute;

class SanctionsManager
{
    /** @var Ban[] */
    private array $bans = [];
    /** @var Mute[] */
    private array $mutes = [];

    public function load(): void {

    }

    public function save(): void {

    }

    public function getBans(): array {
        return $this->bans;
    }

    public function getBan(string $playerName): ?Ban {
        return $this->bans[$playerName] ?? null;
    }

    public function isBanned(string $playerName): bool {
        return isset($this->bans[$playerName]);
    }

    public function addBan(string $playerName, Ban $ban, bool $new): void {
        if($new){
            $ev = new PlayerBanEvent($playerName, $ban);
            if($ev->isCancelled()){
                return;
            }
            $ev->call();
        }

        $this->bans[$playerName] = $ban;
    }

    public function getMutes(): array {
        return $this->mutes;
    }

    public function getMute(string $playerName): ?Mute {
        return $this->mutes[$playerName] ?? null;
    }

    public function isMuted(string $playerName): bool {
        return isset($this->mutes[$playerName]);
    }

    public function addMute(string $playerName, Mute $mute, bool $new = false): void {
        if($new){
            $ev = new PlayerMuteEvent($playerName, $mute);
            if($ev->isCancelled()){
                return;
            }
            $ev->call();
        }

        $this->mutes[$playerName] = $mute;
    }
}
