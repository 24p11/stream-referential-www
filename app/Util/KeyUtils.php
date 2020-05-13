<?php


namespace App\Util;


class KeyUtils
{
    public const SEPARATOR = ':';

    public static function key(...$keys): string
    {
        return implode(self::SEPARATOR, $keys);
    }
}
