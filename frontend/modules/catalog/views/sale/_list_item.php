<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Sale $model
 */

?>

<?= Html::beginTag('a', ['href' => $model->getUrl(), 'class' => 'one-prod-tile']); ?>

    <object>
        <div href="javascript:void(0);" class="request-price">
            Запросить цену
        </div>
    </object>
    <div class="img-cont">
        <?= Html::img($model->getImageLink()); ?>
        <div class="brand">
            <?= $model['factory']['lang']['title'] ?>
        </div>
    </div>
    <div class="item-infoblock">
        <?= $model->getTitle() ?>
    </div>

<?= Html::endTag('a'); ?>