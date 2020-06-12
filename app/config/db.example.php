<?php

return DEBUG ? [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'host1',
    'username'  => 'host1',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => ''
] : [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'markmain_fun',
    'username'  => 'markmain_fun',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => ''
];