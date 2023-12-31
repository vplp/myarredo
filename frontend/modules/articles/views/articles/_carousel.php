<?php

use yii\helpers\Html;
use frontend\modules\articles\models\Article;

/** @var $model Article */

$images = $model->getGalleryImageThumb();
?>


<?php
foreach ($images as $key => $src) {
    echo Html::beginTag('div', [
            'class' => 'article-img',
        ]) .
        Html::img($src['img'], []) .
        Html::endTag('div');
} ?>
