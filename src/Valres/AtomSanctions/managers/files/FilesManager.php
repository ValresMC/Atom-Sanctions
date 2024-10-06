<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions\managers\files;

use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use Valres\AtomSanctions\AtomSanctions;

class FilesManager
{
    const BANS = "sanctions-cache/bans.yml";
    const MUTES = "sanctions-cache/mutes.yml";

    use SingletonTrait;

    public function load(): void {
        @mkdir(AtomSanctions::getInstance()->getDataFolder() . "sanctions-cache/");
        $files = ["bans", "mutes"];

        foreach($files as $file){
            AtomSanctions::getInstance()->saveResource("sanctions-cache/" . $file . ".yml");
        }
    }

    public function getFile(string $path): Config {
        return new Config(AtomSanctions::getInstance()->getDataFolder() . $path, Config::YAML);
    }
}