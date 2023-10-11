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
class AppAsset1 extends AssetBundle
{
    /**
     * @var string
     */

    public $sourcePath = '@app/themes/myarredo/app/public';

    /**
     * @var array
     */
    public $css = [

    ];

    /**
     * @var array
     */
    public $js = [

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
