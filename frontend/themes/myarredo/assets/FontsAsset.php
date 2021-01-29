<?php

namespace frontend\themes\myarredo\assets;

use yii\web\View;
use yii\web\YiiAsset;
use yii\web\AssetBundle;
use yii\bootstrap\{
    BootstrapAsset,
    BootstrapPluginAsset
};

/**
 * Class FontsAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class FontsAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/themes/myarredo/app/public';

    /**
     * @var array
     */
    public $css = [
        'css/fonts.css'
    ];

    /**
     * @var array
     */
    public $js = [];

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        //BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];

    /**
     * @var array
     */
    public $jsOptions = [
        'async' => true,
        'defer' => true,
    ];

    /**
     * @var array
     */
    public $cssOptions = [
        'position' => View::POS_END,
        'rel' => 'preload',
        'as' => 'style'
    ];
}
