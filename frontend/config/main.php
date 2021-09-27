<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    ArrayHelper::merge(
        require(dirname(__DIR__, 2) . '/common/config/main.php'),
        [
            'id' => 'app-frontend',
            'basePath' => dirname(__DIR__),
            'sourceLanguage' => 'de-AT',
            'runtimePath' => '@runtime/frontend',
            'layoutPath' => '@app/layouts',
            'bootstrap' => require __DIR__ . '/bootstrap.php',
            'components' => require __DIR__ . '/components.php',
            'modules' => require(__DIR__ . '/modules.php'),
            // добавление обратного слэша в конце адресной строки
            'on beforeRequest' => function () {
                $pathInfo = Yii::$app->request->pathInfo;

                if (in_array($_SERVER['HTTP_HOST'], ['myarredo.com', 'www.myarredo.com']) && $_SERVER['REQUEST_URI'] == '/') {
                    Yii::$app->response->redirect('/it/', 301)->send();
                    die;
                } elseif (strripos($pathInfo, '.txt') ||
                    strripos($pathInfo, '.xml') ||
                    strripos($pathInfo, '.jpg') ||
                    strripos($pathInfo, '.png')
                ) {
                    //die;
                } elseif ($_SERVER['REQUEST_URI'] == '/it') {
                    Yii::$app->response->redirect('/it/', 301)->send();
                    die;
                } elseif (!empty($pathInfo) &&
                    Yii::$app->request->isGet &&
                    strpos($pathInfo, 'debug/default') === false &&
                    substr($pathInfo, -1) !== '/'
                ) {
                    Yii::$app->response->redirect('/' . rtrim($pathInfo) . '/', 301)->send();
                    die;
                }
            },
            'params' => require __DIR__ . '/params.php',
        ]
    ),
    require __DIR__ . '/main-local.php'
);
