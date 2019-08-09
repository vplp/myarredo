<?php

$baseDirExecPath = dirname(__DIR__, 2);
//
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
require($baseDirExecPath . '/vendor/autoload.php');

Dotenv\Dotenv::create($baseDirExecPath, '.app.env')->load();

require($baseDirExecPath . '/vendor/yiisoft/yii2/Yii.php');
(new yii\web\Application(require($baseDirExecPath . '/backend/config/main.php')))->run();
