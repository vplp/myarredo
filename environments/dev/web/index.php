<?php

$exp = explode('.', $_SERVER['HTTP_HOST']);

defined('DOMAIN_NAME') or define('DOMAIN_NAME', $exp[1]);

if ($exp[2] && $exp[3]) {
    defined('DOMAIN_TYPE') or define('DOMAIN_TYPE', $exp[2] . '.' . $exp[3]);
} else {
    defined('DOMAIN_TYPE') or define('DOMAIN_TYPE', $exp[2] != 'test' ? $exp[2] : 'ru');
}

$baseDirExecPath = dirname(__DIR__, 1);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require($baseDirExecPath . '/vendor/autoload.php');

Dotenv\Dotenv::create($baseDirExecPath, '.app.env')->load();

require($baseDirExecPath . '/vendor/yiisoft/yii2/Yii.php');
(new yii\web\Application(require($baseDirExecPath . '/frontend/config/main.php')))->run();
