<?php

namespace thread\widgets\editors\tinymce\assets;

use yii\web\AssetBundle;

/**
 * Class AssetTinymce
 * 
 * @package thread\extensions\editors\tinymce\assets
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class AssetTinymce extends AssetBundle {

    public $sourcePath = '@vendor/tinymce/tinymce';
    public $js = [
        'tinymce.jquery.min.js',
    ];

}
