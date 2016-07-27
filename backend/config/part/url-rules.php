<?php

return [
    'gii' => 'gii',
    // Module [[Users]]
    'sigin' => 'user/sigin',
    'login' => 'user/login',
    'logout' => 'user/logout',
    // General rules
    '<_m:[\w\-]+>/<_sm:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_sm>/<_c>/<_a>',
    '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
    // Модуль [[Home]]
    '' => 'home/home/index',
    'page' => 'page/page/list'
];
