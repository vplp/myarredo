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
 * Class TemplateFactoryAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class TemplateFactoryAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/themes/myarredo/app/public';

    /**
     * @var array
     */
    public $css = [
        'css/bootstrap.min.css',
        'libs/nouislider/nouislider.min.css',
        'libs/font-awesome/css/font-awesome.min.css',
        'libs/slick-1.6/slick.css',
        'libs/bootstrap-select/css/bootstrap-select.min.css',
        //'css/fonts.css',
        'libs/fancybox/jquery.fancybox.css',
        // 'css/main.scss.min.css',
        'libs/formstyler/jquery.formstyler.css',
        'libs/intl-input/intlTelInput.min.css',
        'css/template-style.min.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'libs/bootstrap-select/js/bootstrap-select.min.js',
        'libs/slick-1.6/slick.min.js',
        'libs/nouislider/nouislider.min.js',
        'libs/infoBubble/infobubble.js',
        'libs/wNumb.js',
        'libs/shop.js',
        'libs/Vibrant.min.js',
        'libs/formstyler/jquery.formstyler.js',
        'libs/fancybox/jquery.fancybox.pack.js',
        'libs/lazyload/lazyload.min.js',
        'libs/intl-input/intlTelInput.min.js',
        'libs/vue/vue.min.js',
        'js/main.js',
    ];

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
        'position' => View::POS_END
    ];
}
