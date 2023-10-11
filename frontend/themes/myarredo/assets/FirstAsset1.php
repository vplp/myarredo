<?php

namespace frontend\themes\myarredo\assets;

use yii\web\View;
use yii\web\AssetBundle;

/**
 * Class FirstAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class FirstAsset1 extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/themes/myarredo/app/public';

    /**
     * @var array
     */
    public $css = [
        'css/first.min.css'
    ];

    /**
     * @var array
     */
    public $js = [];

    /**
     * @var array
     */
    public $depends = [];

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
        'position' => View::POS_HEAD
    ];
}
