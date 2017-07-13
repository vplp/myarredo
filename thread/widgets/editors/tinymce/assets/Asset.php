<?php

namespace thread\widgets\editors\tinymce\assets;

use yii\web\AssetBundle;

/**
 * Class Asset
 * 
 * @package thread\extensions\editors\tinymce\assets
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Asset extends AssetBundle {
    /**
     * @var array
     */
    public $depends = [
        \yii\web\JqueryAsset::class,
        \yii\web\YiiAsset::class,
        AssetTinymce::class,
        AssetLang::class,
    ];

}
