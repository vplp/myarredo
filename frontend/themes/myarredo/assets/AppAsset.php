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
 * Class AppAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/themes/myarredo/app/public';

    /**
     * @var array
     */
    public $css = [
        'libs/nouislider/nouislider.min.css',
        'libs/slick-1.6/slick.css',
        'libs/bootstrap-select/css/bootstrap-select.min.css',
        'libs/fancybox/jquery.fancybox.css',
        'libs/formstyler/jquery.formstyler.css',
        'libs/intl-input/intlTelInput.min.css',
        'css/template-style.min.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'libs/vue/vue.min.js',
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
        'js/main.js'
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

    public function init()
    {
        parent::init();
        if (\Yii::$app->request->url == '/promo2/') {
            $this->css = [];
            $this->js = [];
        }
    }
}
