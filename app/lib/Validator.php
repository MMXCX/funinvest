<?php


namespace Lib;


class Validator
{
    public static function email(string $email): bool
    {
        $len = iconv_strlen($email);

        $preg = preg_match('#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$#', $email);

        return $len >= 5 && $len <= 50 && $preg ?: false;
    }
}