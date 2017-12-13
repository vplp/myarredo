<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<?= Html::beginTag('a', [
    'href' => '#',
    'class' => 'one-prod-tile'
]); ?>

    <div class="img-cont">

        <?= Html::img(Product::getImageThumb($model['product']['image_link'])); ?>

        <div class="brand"><?= $model['count']; ?></div>

    </div>

    <div class="item-infoblock">
        <?= $model['product']['id']; ?> <?= Product::getStaticTitle($model['product']); ?>
    </div>

<?= Html::endTag('a'); ?>