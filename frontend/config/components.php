<?php

$exp = explode('.', $_SERVER['HTTP_HOST']);

return [
    'languages' => [
        'class' => \frontend\modules\sys\components\Languages::class,
        'languageModel' => \frontend\modules\sys\models\Language::class,
    ],
    'session' => [
        'cookieParams' => [
            'domain' => '.' . DOMAIN_NAME . '.' . $exp[2],
            //'httpOnly' => true,
            'path' => '/',
        ],
        'name' => 'PHPBACKSESSID',
    ],
    'user' => [
        'enableAutoLogin' => false,
        'identityCookie' => [
            'name' => '_identity',
            'domain' => '.' . DOMAIN_NAME . '.' . $exp[2],
            //'httpOnly' => true,
            'path' => '/',
        ],
    ],
    'urlManager' => [
        'suffix' => '/',
        'rules' => require __DIR__ . '/part/url-rules.php',
    ],
    'errorHandler' => [
        'errorAction' => 'home/home/error',
    ],
    'request' => [
        'class' => \thread\app\web\Request::class,
        'enableCsrfValidation' => true,
        'enableCookieValidation' => true,
        'cookieValidationKey' => \getenv('THREAD_COOKIE_VALIDATION_KEY'),
        'csrfCookie' => [
            'name' => '_csrf',
            'path' => '/',
            'domain' => '.' . DOMAIN_NAME . '.' . $exp[2],
        ],
    ],
    'view' => [
        //'class' => \thread\app\web\View::class,
	'class' => '\rmrevin\yii\minify\View',
	'enableMinify' => false,//!YII_DEBUG,
	'concatCss' => true, // concatenate css
	'minifyCss' => true, // minificate css
	'concatJs' => true, // concatenate js
	'minifyJs' => true, // minificate js
	'minifyOutput' => true, // minificate result html page
	'webPath' => '@web', // path alias to web base
	'basePath' => '@webroot', // path alias to web base
	'minifyPath' => '@webroot/minify', // path alias to save minify result
	'jsPosition' => [ \yii\web\View::POS_END ], // positions of js files to be minified
	'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
	'expandImports' => true, // whether to change @import on content
	'compressOptions' => ['extra' => true],
	'excludeFiles' => [
		'jquery.min.js',
		'app-[^.].js',
	],
        'theme' => [
            'basePath' => '@app/themes/myarredo',
            'baseUrl' => '@web/themes/myarredo',
            'pathMap' => [
                '@app/layouts' => '@app/themes/myarredo/layouts',
            ],
        ],
    ],
    'assetManager' => [
        //Використовуємо для постійного оновлення assets
        //потрібно для верстальника
        //обовязково очистити директорію /frontend/assets
        'linkAssets' => true,
        'baseUrl' =>  '//css.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . '/assets',
        'bundles' => [
            'yii\web\YiiAsset' => [
                'cssOptions' => [
                    'position' => \yii\web\View::POS_END
                ],
            ],
            'yii\bootstrap\BootstrapAsset' => false,
//            'yii\bootstrap\BootstrapAsset' => [
//                'cssOptions' => [
//                    'position' => \yii\web\View::POS_END
//                ],
//            ],
        ],
    ],
    'catalogFilter' => [
        'class' => \frontend\modules\catalog\components\CatalogFilter::class,
    ],
    'city' => [
        'class' => \frontend\modules\location\components\CityComponent::class,
    ],
    'currency' => [
        'class' => \frontend\modules\location\components\CurrencyComponent::class,
    ],
    'partner' => [
        'class' => \frontend\modules\user\components\PartnerComponent::class,
    ],
    'metatag' => [
        'class' => \frontend\modules\seo\components\MetaTag::class
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache',
        'cachePath' => BASE_PATH . '/runtime/cache',
    ],
];
