<?php

$baseDirExecPath = dirname(__DIR__, 1);
//
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
require($baseDirExecPath . '/vendor/autoload.php');

Dotenv\Dotenv::create($baseDirExecPath, '.yii.env')->load();

require($baseDirExecPath . '/vendor/yiisoft/yii2/Yii.php');
(new yii\web\Application(require($baseDirExecPath . '/frontend/config/main.php')))->run();
