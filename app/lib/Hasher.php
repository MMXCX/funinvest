<?php

namespace Lib;

class Hasher
{
    private static function _hasher(string $str): string
    {
        return hash('sha512', hash('sha512', $str . 'this_is salt skjdfhl8abvakfvbka'));
    }

    public static function hashe(string $str, int $len = 128): string
    {
        $hash = self::_hasher($str);

        return $len == 128 ? $hash : substr($hash, 0, $len);
    }

    public static function compare(string $hash, string $str): bool
    {
        return $hash == self::_hasher($str);
    }
}