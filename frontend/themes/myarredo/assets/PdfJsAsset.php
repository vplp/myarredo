<?php

namespace frontend\themes\myarredo\assets;

use yii\web\AssetBundle;

/**
 * Class PdfJsAsset
 *
 * @package frontend\themes\myarredo\assets
 */
class PdfJsAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/themes/myarredo/pdfjs';

    /**
     * @var array
     */
    public $css = [
        'web/viewer.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'build/pdf.js',
        'build/pdf.worker.js',
        'web/viewer.js'
    ];
}
