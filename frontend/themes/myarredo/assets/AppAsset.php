<?php

namespace frontend\themes\myarredo\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap\{
    BootstrapAsset,
    BootstrapPluginAsset
};

/**
 * Class AppAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/myarredo/app/public';

    public $css = [
        'libs/nouislider/nouislider.min.css',
        'libs/slick-1.6/slick.css',
        'css/fonts.css',
        'css/main.scss.css',
    ];

    public $js = [
        'https://use.fontawesome.com/35f65baac5.js',
        'libs/slick-1.6/slick.min.js',
        'libs/nouislider/nouislider.min.js',
        'libs/wNumb.js',
        'js/core.js',

    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
}