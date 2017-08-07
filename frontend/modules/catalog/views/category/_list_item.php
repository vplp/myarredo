<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<?= Html::beginTag('a', ['href' => $model->getUrl(), 'class' => 'one-prod-tile']); ?>

    <object>
        <div href="javascript:void(0);" class="request-price">
            Запросить цену
        </div>
    </object>
    <div class="img-cont">
        <img src="public/img/pictures/prod-cat1.jpeg" alt="">
        <div class="brand">
            <?= $model['factory']['lang']['title'] ?>
        </div>
    </div>
    <div class="item-infoblock">
        <?= $model->getProductTitle() ?>
    </div>

<?= Html::endTag('a'); ?>