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