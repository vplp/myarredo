<?php

namespace frontend\themes\myarredo\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Class JqueryUiAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class JqueryUiAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/myarredo/app/public';

    public $css = [
        'libs/jqueryui/jquery-ui.min.css',
        'libs/jqueryui/jquery-ui.structure.min.css',
        'libs/jqueryui/jquery-ui.theme.min.css',
    ];

    public $js = [
        'libs/jqueryui/jquery-ui.min.js',
        'libs/daterangepicker.jQuery.js',
    ];

    public $depends = [
        YiiAsset::class,
    ];
}