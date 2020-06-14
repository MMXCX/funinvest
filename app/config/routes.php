<?php

return [
    // MainController
    '' => [
        'controller' => 'main',
        'action' => 'index'
    ],

    // PageController
    'about' => [
        'controller' => 'page',
        'action' => 'about'
    ],
    'contact' => [
        'controller' => 'page',
        'action' => 'contact'
    ],
    'terms' => [
        'controller' => 'page',
        'action' => 'terms'
    ],

    // AuthController
    'login' => [
        'controller' => 'auth',
        'action' => 'login'
    ],
    'register' => [
        'controller' => 'auth',
        'action' => 'register'
    ],
    'ref/{id:\w+}' => [
        'controller' => 'auth',
        'action' => 'ref'
    ],
    'confirm/{key:\w+}' => [
        'controller' => 'auth',
        'action' => 'confirm'
    ],
    'recovery' => [
        'controller' => 'auth',
        'action' => 'recovery'
    ],
    'set-password/{key:\w+}' => [
        'controller' => 'auth',
        'action' => 'set_pass'
    ],
    'logout' => [
        'controller' => 'auth',
        'action' => 'logout'
    ],

    // CabinelController
    'panel' => [
        'controller' => 'cabinet',
        'action' => 'panel'
    ],
    'settings' => [
        'controller' => 'cabinet',
        'action' => 'settings'
    ],







    // ApiController
    'api' => [
        'controller' => 'api',
        'action' => 'index'
    ]






    //    'reg/{ref:\w+}' => [
];