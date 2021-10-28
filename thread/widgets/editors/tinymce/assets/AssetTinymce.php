<?php

namespace thread\widgets\editors\tinymce\assets;

use yii\web\AssetBundle;

/**
 * Class AssetTinymce
 *
 * @package thread\extensions\editors\tinymce\assets
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class AssetTinymce extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/tinymce/tinymce';
    /**
     * @var array
     */
    public $js = [
        'tinymce.min.js',
    ];

}
