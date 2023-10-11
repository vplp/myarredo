<?php

namespace frontend\themes\myarredo\assets;

use yii\web\View;
use yii\web\AssetBundle;

/**
 * Class DataRangePickerAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class DataRangePickerAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/themes/myarredo/app/public';

    /**
     * @var array
     */
    public $css = [
        'libs/jqueryui/jquery-ui.min.css',
        'libs/jqueryui/jquery-ui.structure.min.css',
        'libs/jqueryui/jquery-ui.theme.min.css'
    ];

    /**
     * @var array
     */
    public $js = [
        'libs/jqueryui/jquery-ui.min.js',
        'libs/daterangepicker.jQuery.js',
    ];

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
        'position' => View::POS_END
    ];
}
