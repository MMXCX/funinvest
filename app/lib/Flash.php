<?php


namespace Lib;


class Flash
{
    public static function message($param): string
    {
        $type = $param[0];
        $title = $param[1];
        $body = $param[2];

        $str = require_once '_flashTemplate.php';

        return !empty($param) ? $str : '';
    }

    public static function success($message): string
    {
        $type = 'success';
        $title = 'Успешно!';
        $body = $message;

        return $message ? require_once '_flashTemplate.php' : '';
    }

    public static function error($message): string
    {
        $type = 'danger';
        $title = 'Ошибка!';
        $body = $message;

        return $message ? require_once '_flashTemplate.php' : '';
    }
}