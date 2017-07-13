<?php
$baseDirExecPath = dirname(__DIR__, 1);
//
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require($baseDirExecPath . '/vendor/autoload.php');
require($baseDirExecPath . '/vendor/yiisoft/yii2/Yii.php');
(new yii\web\Application(require($baseDirExecPath . '/frontend/config/main.php')))->run();