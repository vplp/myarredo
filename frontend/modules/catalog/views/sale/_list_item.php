<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\Sale;

/**
 * @var \frontend\modules\catalog\models\Sale $model
 */

?>

<?= Html::beginTag('a', [
    'href' => $model->getUrl(), 'class' => 'one-prod-tile'
]); ?>

    <div class="img-cont">

        <?= Html::img(Sale::getImageThumb($model['image_link'])); ?>

        <div class="brand">
            <?= $model['factory']['lang']['title'] ?>
        </div>

    </div>

    <div class="item-infoblock">
        <?= $model->getTitle() ?>
    </div>

<?= Html::endTag('a'); ?>