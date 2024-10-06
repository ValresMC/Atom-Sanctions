<?php

declare(strict_types = 1);

namespace Valres\AtomSanctions\utils;

final class TimeHelper
{
    public static array $timeUnits = [
        "y" => 31536000,
        "M" => 2635200,
        "w" => 604800,
        "d" => 86400,
        "h" => 3600,
        "m" => 60,
        "s" => 1
    ];

    public static function stringToTime(string $timeString): int {
        $totalSeconds = 0;
        $matches = [];

        preg_match_all('/(\d+)([yMwdhms])/', $timeString, $matches, PREG_SET_ORDER);

        foreach($matches as $match){
            $quantity = intval($match[1]);
            $unit = $match[2];
            if(isset(self::$timeUnits[$unit])){
                $totalSeconds += $quantity * self::$timeUnits[$unit];
            }
        }

        return time() + $totalSeconds;
    }

    public static function timeToString(int $time): string {
        $remaining = $time - time();
        if($remaining < 0) return "0s";

        $formatTemp = '';

        foreach(self::$timeUnits as $unit => $value){
            if($remaining >= $value){
                $quantity = intval($remaining / $value);
                $formatTemp .= $quantity . $unit . ' ';
                $remaining -= $quantity * $value;
            }
        }

        return trim($formatTemp);
    }

    public static function timestampToDate(int $timestamp, string $format = 'Y-m-d H:i:s'): string {
        return date($format, $timestamp);
    }
}
