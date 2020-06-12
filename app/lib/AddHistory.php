<?php

namespace app\lib;

class AddHistory
{
    public static function insertHistoryLineById($id, $type, $description, $value, $db)
    {
        $db->query("INSERT INTO `history` (`user_id`,`time`,`type`,`descr`,`value`) VALUES (?i,?i,?s,?s,?i)", $id, time(), $type, $description, $value);
    }
}