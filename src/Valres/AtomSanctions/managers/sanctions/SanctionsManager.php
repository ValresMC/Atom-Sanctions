<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions\managers\sanctions;

use JsonException;
use pocketmine\utils\Config;
use Valres\AtomSanctions\events\PlayerBanEvent;
use Valres\AtomSanctions\events\PlayerMuteEvent;
use Valres\AtomSanctions\managers\files\FilesManager;
use Valres\AtomSanctions\managers\sanctions\types\Ban;
use Valres\AtomSanctions\managers\sanctions\types\Mute;

class SanctionsManager
{
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

        foreach($this->banDatas->getAll() as $playerName => $data){
            $ban = new Ban($playerName, $data["time"], $data["reason"], $data["authorName"]);
            $this->addBan($playerName, $ban);
        }

        foreach($this->muteDatas->getAll() as $playerName => $data){
            $mute = new Mute($playerName, $data["time"], $data["reason"], $data["authorName"]);
            $this->addMute($playerName, $mute);
        }

        $this->banDatas->setAll([]);
        $this->muteDatas->setAll([]);
        $this->saveData();
    }

    /** @throws JsonException */
    public function save(): void {
        foreach($this->bans as $playerName => $ban){
            $this->banDatas->set($playerName, [
                "time" => $ban->getTime(),
                "reason" => $ban->getReason(),
                "authorName" => $ban->getAuthorName()
            ]);
        }

        foreach($this->mutes as $playerName => $mute){
            $this->muteDatas->set($playerName, [
                "time" => $mute->getTime(),
                "reason" => $mute->getReason(),
                "authorName" => $mute->getAuthorName()
            ]);
        }

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

    public function addBan(string $playerName, Ban $ban, bool $new = false): void {
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

    /** @throws JsonException */
    public function saveData(): void {
        $this->banDatas->save();
        $this->muteDatas->save();
    }
}
