<?php

namespace backend\themes\defaults\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 *
 * @package backend\themes\defaults\assets
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@backend/themes/defaults/web';
    /**
     * @var array
     */
    public $css = [
        'css/style.css'
    ];
    /**
     * @var array
     */
    public $js = [
        'js/script.js'
    ];
    /**
     * @var array
     */
    public $depends = [
        \yii\web\YiiAsset::class,
        \yii\bootstrap\BootstrapAsset::class,
    ];
}
