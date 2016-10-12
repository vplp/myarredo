<?php

namespace thread\widgets\editors\tinymce\assets;

use yii\web\AssetBundle;

/**
 * Class AssetLang
 * 
 * @package thread\extensions\editors\tinymce\assets
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

class AssetLang extends AssetBundle {
    /**
     * @var string
     */
    public $sourcePath = __DIR__;
    /**
     * @var array
     */
    public $js = [
        'langs/uk-UA.js',
        'langs/ru-RU.js',
    ];

}
