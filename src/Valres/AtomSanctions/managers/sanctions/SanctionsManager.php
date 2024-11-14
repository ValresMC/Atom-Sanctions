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

use JsonException;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use Valres\AtomSanctions\events\BanEvent;
use Valres\AtomSanctions\events\MuteEvent;
use Valres\AtomSanctions\managers\files\FilesManager;
use Valres\AtomSanctions\managers\sanctions\types\Ban;
use Valres\AtomSanctions\managers\sanctions\types\Mute;

class SanctionsManager
{
    use SingletonTrait;

    /** @var Ban[] */
    private array $bans = [];
    /** @var Mute[] */
    private array $mutes = [];

    private Config $banDatas;
    private Config $muteDatas;

    /** @throws JsonException */
    public function load(): void {
        $this->banDatas  = FilesManager::getInstance()->getFile(FilesManager::BANS);
        $this->muteDatas = FilesManager::getInstance()->getFile(FilesManager::MUTES);

        foreach($this->banDatas->getAll() as $data) $this->addBan(Ban::fromArray($data));
        foreach($this->muteDatas->getAll() as $data) $this->addMute(Mute::fromArray($data));

        $this->banDatas->setAll([]);
        $this->muteDatas->setAll([]);
        $this->saveData();
    }

    /** @throws JsonException */
    public function save(): void {
        $bans = [];
        foreach($this->bans as $ban) $bans[] = $ban->toArray();
        $this->banDatas->setAll($bans);

        $mutes = [];
        foreach($this->mutes as $playerName => $mute) $mutes[] = $mute->toArray();
        $this->muteDatas->setAll($mutes);

        $this->saveData();
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

    public function addBan(Ban $ban, bool $new = false): void {
        if($ban->getTime() < time()) return;
        if($new){
            $ev = new BanEvent($ban);
            if($ev->isCancelled()){
                return;
            }
            $ev->call();
        }

        $this->bans[$ban->getPlayerName()] = $ban;
    }

    public function deleteBan(string $playerName): void {
        unset($this->bans[$playerName]);
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

    public function addMute(Mute $mute, bool $new = false): void {
        if($mute->getTime() < time()) return;
        if($new){
            $ev = new MuteEvent($mute);
            if($ev->isCancelled()) return;
            $ev->call();
        }

        $this->mutes[$mute->getPlayerName()] = $mute;
    }

    public function deleteMute(string $playerName): void {
        unset($this->mutes[$playerName]);
    }

    /** @throws JsonException */
    public function saveData(): void {
        $this->banDatas->save();
        $this->muteDatas->save();
    }
}
