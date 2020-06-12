<?php

namespace app\lib;

class CurrentKurs {
    public static function getUSD()
    {
        // $kurs = (float)json_decode(file_get_contents("https://www.cbr-xml-daily.ru/daily_json.js"))->Valute->USD->Value;
        $kurs = 64.356;
        return $kurs;
    }
}