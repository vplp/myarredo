<?php
return [
    'db' => [
        'dsn' => 'mysql:host=' . \getenv('THREAD_DB_HOST') . ';dbname=' . \getenv('THREAD_DB_NAME'),
        'username' => \getenv('THREAD_DB_USER_NAME'),
        'password' => \getenv('THREAD_DB_USER_PASSWORD'),
        'charset' => 'utf8',
        'tablePrefix' => 'fv_',
    ],
    'db-core' => [
        'dsn' => 'mysql:host=' . \getenv('THREAD_DB_HOST') . ';dbname=' . \getenv('THREAD_DB_NAME'),
        'username' => \getenv('THREAD_DB_USER_NAME'),
        'password' => \getenv('THREAD_DB_USER_PASSWORD'),
        'charset' => 'utf8',
        'tablePrefix' => 'fv_',
    ],
];
