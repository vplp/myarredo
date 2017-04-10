<?php

namespace backend\themes\inspinia\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 *
 * @package backend\themes\inspinia\assets
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@backend/themes/inspinia/web';
    /**
     * @var array
     */
    public $css = [
        // Font awesome
        'css/font-awesome/css/font-awesome.min.css',
        // Plugins
        'css/plugins/iCheck/custom.min.css',
        // Base
        'css/animate.min.css',
        'css/style.min.css',
        'css/backend.min.css',
    ];
    /**
     * @var array
     */
    public $js = [
        // Mainly scripts
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        // Flot
        'js/plugins/flot/jquery.flot.min.js',
        'js/plugins/flot/jquery.flot.tooltip.min.js',
        'js/plugins/flot/jquery.flot.spline.min.js',
        'js/plugins/flot/jquery.flot.resize.min.js',
        'js/plugins/flot/jquery.flot.pie.min.js',
        'js/plugins/flot/jquery.flot.symbol.min.js',
        'js/plugins/flot/jquery.flot.time.min.js',
        // Custom and plugin javascript
        'js/inspinia.js',
        'js/plugins/pace/pace.min.js',
        'js/plugins/iCheck/icheck.min.js',
        // Sparkline
        'js/plugins/sparkline/jquery.sparkline.min.js',
        'js/plugins/sparkline/sparkline-custom.js',
        //Sortable
        'js/sortable/jquery-sortable-1491772244567.js',
        //Backend
        'js/backend.js',
    ];
    /**
     * @var array
     */
    public $depends = [
        \yii\web\YiiAsset::class,
        \yii\bootstrap\BootstrapAsset::class,
    ];
}
