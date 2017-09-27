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
        'css/main.scss.css',
        'libs/nouislider/nouislider.min.css',
        'libs/slick-1.6/slick.css',
        'libs/bootstrap-select/css/bootstrap-select.min.css',
        'css/fonts.css',
    ];

    public $js = [
        'https://use.fontawesome.com/35f65baac5.js',
        'libs/bootstrap-select/js/bootstrap-select.min.js',
        'libs/slick-1.6/slick.min.js',
        'libs/nouislider/nouislider.min.js',
        'libs/wNumb.js',
        'libs/shop.js',
        'js/core.js',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
}