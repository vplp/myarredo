<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Sale;

/** @var $model Sale */

$images = $model->getGalleryImageThumb();
/* !!! */ echo  '<pre style="color:red;">'; print_r($images); echo '</pre>'; /* !!! */
?>


<?php
foreach ($images as $key => $src) {
    echo Html::beginTag('div', [
            'class' => '',
        ]) .
        Html::img($src['img'], []) .
        Html::endTag('div');
} ?>
