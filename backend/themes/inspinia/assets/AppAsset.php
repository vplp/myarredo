<?php

namespace backend\themes\inspinia\assets;

use yii\web\AssetBundle;
/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/inspinia';
    public $baseUrl = '@web/themes/inspinia';
    public $css = [
        // Font awesome
        'css/font-awesome/css/font-awesome.min.css',
        // Plugins
        'css/plugins/iCheck/custom.css',
        // Base
        'css/animate.css',
        'css/style.css',
        'css/backend.css',
    ];
    public $js = [
        // Mainly scripts
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        // Flot
        'js/plugins/flot/jquery.flot.js',
        'js/plugins/flot/jquery.flot.tooltip.min.js',
        'js/plugins/flot/jquery.flot.spline.js',
        'js/plugins/flot/jquery.flot.resize.js',
        'js/plugins/flot/jquery.flot.pie.js',
        'js/plugins/flot/jquery.flot.symbol.js',
        'js/plugins/flot/jquery.flot.time.js',
        // Custom and plugin javascript
        'js/inspinia.js',
        'js/plugins/pace/pace.min.js',
        'js/plugins/iCheck/icheck.min.js',
        // Sparkline
        'js/plugins/sparkline/jquery.sparkline.min.js',
        'js/plugins/sparkline/sparkline-custom.js',
        'js/backend.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
