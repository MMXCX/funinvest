<?php

namespace app\lib;

class Converter
{
    public static function PTCtoRUB($ptc)
    {
        $int = (string)floor($ptc * 0.000000001);
        $float = str_pad((string)($ptc - $int * 1000000000), 9, "0", STR_PAD_LEFT);
        return $int.".".$float;
    }
}