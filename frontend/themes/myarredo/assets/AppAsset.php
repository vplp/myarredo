<?php

namespace frontend\themes\myarredo\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/myarredo/app/public';

    public $css = [
        'libs/formstyler/jquery.formstyler.css',
        'css/fonts.css',
        'css/main.scss.css',
    ];

    public $js = [
        'libs/formstyler/jquery.formstyler.js',
        'js/core.js',

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
