<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Sale $model
 */

?>

<?= Html::beginTag('a', [
    'href' => $model->getUrlUpdate(), 'class' => 'one-prod-tile'
]); ?>

    <div class="img-cont">

        <?= Html::img($model::getImageThumb($model['image_link'])); ?>

        <div class="brand">
            <?= ($model['factory']) ? $model['factory']['title'] : $model['factory_name'] ?>
        </div>

    </div>

    <div class="item-infoblock">
        <?= $model->getTitle() ?>
    </div>

<?= Html::endTag('a'); ?>